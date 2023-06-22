import { getCurrentUserId, isAdmin } from '../app/auth';

export const getReplyCardNode = (
  { user, date, content, user_id },
  onDelete,
) => {
  const container = document.createElement('div');
  container.classList.add('review');
  container.classList.add('mt-4');

  const userNode = document.createElement('div');
  userNode.classList.add('text');
  userNode.classList.add('text__16');
  userNode.classList.add('text__bold');
  userNode.classList.add('mb-1');
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
  topRowNode.appendChild(userNode);

  if (isAdmin() || getCurrentUserId() == user_id) {
    topRowNode.appendChild(deleteButtonNode);
  }

  const contentNode = document.createElement('div');
  contentNode.classList.add('text');
  contentNode.classList.add('text__16');
  contentNode.innerHTML = content;

  container.appendChild(topRowNode);
  container.appendChild(contentNode);

  return container;
};
