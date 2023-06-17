import { getCurrentUserId, isAdmin } from '../app/auth';

export const getReviewNode = (
  { user, book, review_date, content, user_id },
  onDelete,
  showUser = true,
) => {
  const review = document.createElement('div');
  review.classList.add('review');

  const infoNode = document.createElement('div');
  infoNode.classList.add('text');
  infoNode.classList.add('text__16');
  infoNode.classList.add('text__bold');
  infoNode.classList.add('mb-1');

  if (showUser) {
    infoNode.innerHTML = `${user.fullName} - ${review_date}`;
  } else {
    infoNode.innerHTML = `${book.title} - ${review_date}`;
  }

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
  topRowNode.appendChild(infoNode);

  if (isAdmin() || getCurrentUserId() == user_id) {
    topRowNode.appendChild(deleteButtonNode);
  }

  const contentNode = document.createElement('div');
  contentNode.classList.add('text');
  contentNode.classList.add('text__16');
  contentNode.innerHTML = content;

  review.appendChild(topRowNode);
  review.appendChild(contentNode);

  return review;
};
