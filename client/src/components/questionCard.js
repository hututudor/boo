import { getCurrentUserId, isAdmin } from '../app/auth';
import { URL_BASE } from '../config';

export const getQuestionCardNode = (
  { id, user, user_id, title, date, view_count, reply_count },
  onDelete,
) => {
  const container = document.createElement('div');
  container.classList.add('question_card');
  container.addEventListener('click', () => {
    goTo(`${URL_BASE}/help/${id}`);
  });

  const titleNode = document.createElement('div');
  titleNode.classList.add('text');
  titleNode.classList.add('text__16');
  titleNode.classList.add('text__bold');
  titleNode.innerHTML = title;

  const specsNode = document.createElement('div');
  specsNode.classList.add('question_card-specifications');

  const specsDetailsNode = document.createElement('div');
  specsDetailsNode.classList.add('question_card-specifications-details');

  const userWrapperNode = document.createElement('div');
  userWrapperNode.classList.add('question_card-specifications-element');

  const userNode = document.createElement('div');
  userNode.classList.add('text');
  userNode.classList.add('text__14');
  userNode.innerHTML = `${user.fullName} - ${date}`;

  const deleteIconNode = document.createElement('i');
  deleteIconNode.classList.add('fa');
  deleteIconNode.classList.add('fa-trash');

  const deleteButtonNode = document.createElement('button');
  deleteButtonNode.classList.add('button');
  deleteButtonNode.classList.add('button__primary');
  deleteButtonNode.classList.add('button__red');
  deleteButtonNode.appendChild(deleteIconNode);
  deleteButtonNode.addEventListener('click', onDelete);

  const topRowNode = document.createElement('div');
  topRowNode.classList.add('flex');
  topRowNode.classList.add('flex__justify-between');
  topRowNode.classList.add('flex__align-center');
  topRowNode.appendChild(titleNode);

  if (isAdmin() || getCurrentUserId() == user_id) {
    topRowNode.appendChild(deleteButtonNode);
  }

  const specsStatisticsNode = document.createElement('div');
  specsStatisticsNode.classList.add('question_card-specifications-statistics');

  const viewsWrapperNode = document.createElement('div');
  viewsWrapperNode.classList.add('question_card-specifications-element');

  const eyeIcon = document.createElement('i');
  eyeIcon.classList.add('fa');
  eyeIcon.classList.add('fa-eye');

  const viewsNode = document.createElement('div');
  viewsNode.classList.add('text');
  viewsNode.classList.add('text__14');
  viewsNode.innerHTML = view_count;

  viewsWrapperNode.appendChild(eyeIcon);
  viewsWrapperNode.appendChild(viewsNode);

  const repliesWrapperNode = document.createElement('div');
  repliesWrapperNode.classList.add('question_card-specifications-element');

  const commentsIcon = document.createElement('i');
  commentsIcon.classList.add('fa');
  commentsIcon.classList.add('fa-comments');

  const repliesNode = document.createElement('div');
  repliesNode.classList.add('text');
  repliesNode.classList.add('text__14');
  repliesNode.innerHTML = reply_count;

  repliesWrapperNode.appendChild(commentsIcon);
  repliesWrapperNode.appendChild(repliesNode);

  specsStatisticsNode.appendChild(viewsWrapperNode);
  specsStatisticsNode.appendChild(repliesWrapperNode);
  userWrapperNode.appendChild(userNode);
  specsDetailsNode.appendChild(userWrapperNode);
  specsNode.appendChild(specsDetailsNode);
  specsNode.appendChild(specsStatisticsNode);
  container.appendChild(topRowNode);
  container.appendChild(specsNode);

  return container;
};
