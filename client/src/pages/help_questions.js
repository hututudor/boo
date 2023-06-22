import { addReply, deleteReply, getQuestion } from '../api';
import { isAuth } from '../app/auth';
import {
  disableButton,
  enableButton,
  getReplyCardNode,
  hideModal,
  renderSidebar,
  setInputError,
  showModal,
} from '../components';

const pageState = {
  id: 0,
  replyId: 0,
  contentTouched: true,
};

export const load = async () => {
  renderSidebar();

  pageState.id = window.questionId;

  registerFormEvents();
  registerModalEvents();
  registerShowResponseForm();
  await displayQuestion();
};

const displayQuestion = async () => {
  const question = await getQuestion(pageState.id);
  showQuestion(question);
};

const showQuestion = ({
  title,
  content,
  user,
  date,
  view_count,
  reply_count,
  replies,
}) => {
  document.getElementById('title').innerText = title;
  document.getElementById('date').innerText = date;
  document.getElementById('content').innerText = content;
  document.getElementById('user').innerText = user.fullName;
  document.getElementById('view-count').innerText = view_count;
  document.getElementById('reply-count').innerText = reply_count;

  const repliesNode = document.getElementById('replies');
  repliesNode.innerHTML = '';
  replies.forEach(reply =>
    repliesNode.appendChild(getReplyCardNode(reply, showDeleteReply(reply.id))),
  );
};

const registerShowResponseForm = () => {
  if (!isAuth()) {
    document.getElementById('response-form').style.display = 'none';
  }
};

const registerFormEvents = () => {
  const content = document.getElementById('content-field');
  content.addEventListener('keyup', _validateContentField);
  content.addEventListener('blur', _touchField('content'));
  content.addEventListener('blur', _validateContentField);

  const postButton = document.getElementById('post-button');
  postButton.addEventListener('click', handleFormSubmit);
};

const handleFormSubmit = async () => {
  _touchFields();

  const isFormValid = [_validateContentField]
    .map(validator => validator())
    .every(result => !!result);

  if (!isFormValid) {
    return;
  }

  const button = document.getElementById('post-button');

  disableButton(button);

  try {
    await addReply({
      content: document.getElementById('content-field').value,
      id: pageState.id,
    });
  } finally {
    enableButton(button);
  }

  await displayQuestion();

  document.getElementById('content-field').value = '';
};

const _validateContentField = () => {
  if (!pageState.contentTouched) {
    return true;
  }

  const input = document.getElementById('content-field');
  const value = input.value;

  console.log(value, !!value);

  if (!value) {
    setInputError(input, 'Content is required');
    return false;
  }

  setInputError(input, '');
  return true;
};

const _touchFields = () => {
  pageState.contentTouched = true;
};

const _touchField = name => () => {
  const key = `${name}Touched`;
  pageState[key] = true;
};

const registerModalEvents = () => {
  document
    .getElementById('delete-modal-cancel')
    .addEventListener('click', hideDeleteReply);
  document
    .getElementById('delete-modal-delete')
    .addEventListener('click', handleDeleteReply);
};

const showDeleteReply = replyId => () => {
  pageState.replyId = replyId;
  showModal('delete-modal');
};

const hideDeleteReply = () => {
  hideModal('delete-modal');
};

const handleDeleteReply = async () => {
  await deleteReply(pageState.replyId);
  await displayQuestion();
  hideDeleteReply();
};
