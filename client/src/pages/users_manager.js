import { deleteBook } from '../api';
import { deleteUser, demoteUser, listUsers, promoteUser } from '../api/users';
import { checkAdmin, checkAuth, getCurrentUserId } from '../app/auth';
import { hideModal, renderSidebar, showModal } from '../components';

const pageState = {
  id: 0,
};

export const load = async () => {
  renderSidebar();
  checkAdmin();

  registerModalEvents();
  await displayUsers();
};

const displayUsers = async () => {
  const users = await listUsers();
  const container = document.getElementsByClassName('users_manager-rows')[0];
  container.innerHTML = '';

  users.forEach(user => container.appendChild(getUserRow(user)));
};

const getUserRow = ({ id, full_name, email, is_admin }) => {
  const wrapper = document.createElement('div');

  const idNode = document.createElement('div');
  idNode.innerHTML = id;
  idNode.classList.add('text');
  idNode.classList.add('text__16');

  const nameNode = document.createElement('div');
  nameNode.innerHTML = full_name;
  nameNode.classList.add('text');
  nameNode.classList.add('text__16');

  const emailNode = document.createElement('div');
  emailNode.innerHTML = email;
  emailNode.classList.add('text');
  emailNode.classList.add('text__16');
  emailNode.classList.add('users_manager__mobile-hidden');

  const roleNode = document.createElement('div');
  roleNode.innerHTML = is_admin ? 'Admin' : 'User';
  roleNode.classList.add('text');
  roleNode.classList.add('text__16');

  const buttons = document.createElement('div');
  buttons.classList.add('text');
  buttons.classList.add('text__16');

  if (is_admin && getCurrentUserId() !== id) {
    const demote = document.createElement('button');
    demote.classList.add('button');
    demote.classList.add('button__icon');
    demote.classList.add('mr-2');
    demote.addEventListener('click', () => {
      pageState.id = id;
      showDemoteUser();
    });

    const demoteIcon = document.createElement('i');
    demoteIcon.classList.add('fa');
    demoteIcon.classList.add('fa-chevron-down');

    demote.appendChild(demoteIcon);
    buttons.appendChild(demote);
  } else if (!is_admin) {
    const promote = document.createElement('button');
    promote.classList.add('button');
    promote.classList.add('button__icon');
    promote.classList.add('mr-2');
    promote.addEventListener('click', () => {
      pageState.id = id;
      showPromoteUser();
    });

    const promoteIcon = document.createElement('i');
    promoteIcon.classList.add('fa');
    promoteIcon.classList.add('fa-chevron-up');

    promote.appendChild(promoteIcon);
    buttons.appendChild(promote);
  }

  if (getCurrentUserId() !== id) {
    const remove = document.createElement('button');
    remove.classList.add('button');
    remove.classList.add('button__icon');
    remove.classList.add('button__red');
    remove.addEventListener('click', () => {
      pageState.id = id;
      showDeleteUser();
    });

    const removeIcon = document.createElement('i');
    removeIcon.classList.add('fa');
    removeIcon.classList.add('fa-trash');

    remove.appendChild(removeIcon);

    buttons.appendChild(remove);
  }

  wrapper.appendChild(idNode);
  wrapper.appendChild(nameNode);
  wrapper.appendChild(emailNode);
  wrapper.appendChild(roleNode);
  wrapper.appendChild(buttons);

  return wrapper;
};

const registerModalEvents = () => {
  document
    .getElementById('delete-modal-cancel')
    .addEventListener('click', hideDeleteUser);
  document
    .getElementById('delete-modal-delete')
    .addEventListener('click', handleDeleteUser);
  document
    .getElementById('promote-modal-cancel')
    .addEventListener('click', hidePromoteUser);
  document
    .getElementById('promote-modal-delete')
    .addEventListener('click', handlePromoteUser);
  document
    .getElementById('demote-modal-cancel')
    .addEventListener('click', hideDemoteUser);
  document
    .getElementById('demote-modal-delete')
    .addEventListener('click', handleDemoteUser);
};

const showDeleteUser = () => {
  showModal('delete-modal');
};

const hideDeleteUser = () => {
  hideModal('delete-modal');
};

const handleDeleteUser = async () => {
  await deleteUser(pageState.id);
  await displayUsers();
  hideDeleteUser();
};

const showPromoteUser = () => {
  showModal('promote-modal');
};

const hidePromoteUser = () => {
  hideModal('promote-modal');
};

const handlePromoteUser = async () => {
  await promoteUser(pageState.id);
  await displayUsers();
  hidePromoteUser();
};

const showDemoteUser = () => {
  showModal('demote-modal');
};

const hideDemoteUser = () => {
  hideModal('demote-modal');
};

const handleDemoteUser = async () => {
  await demoteUser(pageState.id);
  await displayUsers();
  hideDemoteUser();
};
