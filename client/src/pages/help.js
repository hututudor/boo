import { addQuestion, deleteQuestion, listQuestions } from '../api';
import { isAuth } from '../app/auth';
import {
  disableButton,
  enableButton,
  hideModal,
  renderSidebar,
  showModal,
} from '../components';
import { getQuestionCardNode } from '../components/questionCard';

const pageState = {
  titleTouched: false,
  contentTouched: false,
};

export const load = async () => {
  renderSidebar();

  await displayQuestions();

  registerFormEvents();
  registerModalEvents();
  registerShowResponseForm();
};

const registerFormEvents = () => {
  const title = document.getElementById('title');
  title.addEventListener('keyup', _validateContentField);
  title.addEventListener('blur', _touchField('title'));
  title.addEventListener('blur', _validateContentField);

  const content = document.getElementById('content');
  content.addEventListener('keyup', _validateContentField);
  content.addEventListener('blur', _touchField('content'));
  content.addEventListener('blur', _validateContentField);

  const postButton = document.getElementById('post-button');
  postButton.addEventListener('click', handleFormSubmit);
};

const registerShowResponseForm = () => {
  if (!isAuth()) {
    document.getElementById('response-form').style.display = 'none';
  }
};

const displayQuestions = async () => {
  const questions = await listQuestions();
  showQuestions(questions);
};

const showQuestions = questions => {
  const questionsNode = document.getElementsByClassName(
    'help-container-questions-list',
  )[0];
  questionsNode.innerHTML = '';
  questions.forEach(question =>
    questionsNode.appendChild(
      getQuestionCardNode(question, showDeleteQuestion(question.id)),
    ),
  );
};

const handleFormSubmit = async () => {
  _touchFields();

  const isFormValid = [_validateTitleField, _validateContentField]
    .map(validator => validator())
    .every(result => !!result);

  if (!isFormValid) {
    return;
  }

  const button = document.getElementById('post-button');

  disableButton(button);

  try {
    await addQuestion({
      title: document.getElementById('title').value,
      content: document.getElementById('content').value,
    });
  } finally {
    enableButton(button);
  }

  await displayQuestions();

  document.getElementById('title').value = '';
  document.getElementById('content').value = '';
};

const _validateTitleField = () => {
  if (!pageState.nameTouched) {
    return true;
  }

  const input = document.getElementById('title');
  const value = input.value;

  if (!value) {
    setInputError(input, 'Title is required');
    return false;
  }

  setInputError(input, '');
  return true;
};

const _validateContentField = () => {
  if (!pageState.nameTouched) {
    return true;
  }

  const input = document.getElementById('content');
  const value = input.value;

  if (!value) {
    setInputError(input, 'Content is required');
    return false;
  }

  setInputError(input, '');
  return true;
};

const _touchFields = () => {
  pageState.titleTouched = true;
  pageState.contentTouched = true;
};

const _touchField = name => () => {
  const key = `${name}Touched`;
  pageState[key] = true;
};

const registerModalEvents = () => {
  document
    .getElementById('delete-modal-cancel')
    .addEventListener('click', hideDeleteQuestion);
  document
    .getElementById('delete-modal-delete')
    .addEventListener('click', handleDeleteQuestion);
};

const showDeleteQuestion = replyId => event => {
  event.stopPropagation();
  pageState.replyId = replyId;
  showModal('delete-modal');
};

const hideDeleteQuestion = () => {
  hideModal('delete-modal');
};

const handleDeleteQuestion = async () => {
  await deleteQuestion(pageState.replyId);
  await displayQuestions();
  hideDeleteQuestion();
};
