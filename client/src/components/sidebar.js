import { isAdmin, isAuth, logout } from '../app/auth';
import { getPageName } from '../app/loader';
import { URL_BASE } from '../config';

const sidebarConfig = [
  {
    name: 'Home',
    icon: 'fa-home',
    isActive: () => getPageName() === 'home',
    onClick: () => goTo(URL_BASE + '/home'),
    isHidden: () => !isAuth(),
  },
  {
    name: 'Books',
    icon: 'fa-book',
    isActive: () => getPageName() === 'books',
    onClick: () => goTo(URL_BASE + '/'),
  },
  {
    name: 'Reviews',
    icon: 'fa-comment',
    isActive: () => getPageName() === 'reviews',
    onClick: () => goTo(URL_BASE + '/reviews'),
    isHidden: () => !isAuth(),
  },
  {
    name: 'Books Manager',
    icon: 'fa-table',
    isActive: () => getPageName() === 'books_manager',
    onClick: () => goTo(URL_BASE + '/manager'),
    isHidden: () => !isAdmin(),
  },
  {
    name: 'About',
    icon: 'fa-info-circle',
    isActive: () => getPageName() === 'about',
    onClick: () => goTo(URL_BASE + '/about'),
  },
  {
    name: 'Help',
    icon: 'fa-question-circle',
    isActive: () => getPageName() === 'help',
    onClick: () => goTo(URL_BASE + '/help'),
  },
];

const nonAuthSidebarConfig = [
  {
    name: 'Login',
    icon: 'fa-user',
    isActive: () => false,
    onClick: () => goTo(URL_BASE + '/login'),
  },
  {
    name: 'Register',
    icon: 'fa-user-plus',
    isActive: () => false,
    onClick: () => goTo(URL_BASE + '/register'),
  },
];

const authSidebarConfig = [
  {
    name: 'Profile',
    icon: 'fa-user-circle',
    isActive: () => false,
    onClick: () => goTo(URL_BASE + '/profile'),
  },
  {
    name: 'Logout',
    icon: 'fa-sign-out',
    isActive: () => false,
    onClick: logout,
  },
];

export const renderSidebar = () => {
  const sidebar = document.getElementsByClassName('side-links')?.[0];

  if (!sidebar) {
    return;
  }

  sidebarConfig
    .filter(item => !item?.isHidden || !item.isHidden())
    .forEach(item => sidebar.appendChild(getSidebarItem(item)));
  sidebar.appendChild(getSidebarDivider());

  if (isAuth()) {
    authSidebarConfig.forEach(item =>
      sidebar.appendChild(getSidebarItem(item)),
    );
  } else {
    nonAuthSidebarConfig.forEach(item =>
      sidebar.appendChild(getSidebarItem(item)),
    );
  }

  registerSidebarEvents();
};

const getSidebarItem = ({ onClick, isActive, name, icon }) => {
  const button = document.createElement('button');
  button.classList.add('side-link');
  button.addEventListener('click', onClick);

  if (isActive()) {
    button.classList.add('side-link__active');
  }

  const iconNode = document.createElement('i');
  iconNode.classList.add('fa');
  iconNode.classList.add(icon);

  button.appendChild(iconNode);
  button.append(name);

  return button;
};

const getSidebarDivider = () => {
  const divider = document.createElement('div');
  divider.classList.add('mt-3');
  return divider;
};

export const registerSidebarEvents = () => {
  const button = document
    .getElementsByTagName('nav')[0]
    .getElementsByTagName('button')[0];

  const searchWrapper = document.getElementsByClassName('side-search')[0];
  const searchInput = searchWrapper.querySelector('input');
  const searchButton = searchWrapper.querySelector('i');

  searchInput.addEventListener('keypress', handleSearchKeyPress);
  searchButton.addEventListener('click', search);

  button.addEventListener('click', handleSidebarOpenClose);
};

const handleSearchKeyPress = event => {
  if (event.keyCode == 13) {
    search();
  }
};

const search = () => {
  const queryValue = document.getElementById('search').value;
  if (!queryValue) {
    return;
  }

  const queryParam = new URLSearchParams({ query: queryValue });
  window.location.href = `${URL_BASE}/books/search?${queryParam}`;
};

const isSidebarOpen = () => {
  return document
    .getElementsByTagName('aside')[0]
    .classList.contains('side__show');
};

const handleSidebarOpenClose = () => {
  if (isSidebarOpen()) {
    closeSidebar();
  } else {
    openSidebar();
  }
};

const openSidebar = () => {
  document.getElementsByTagName('aside')[0].classList.add('side__show');
  document
    .getElementsByTagName('nav')[0]
    .getElementsByTagName('i')[0].style.transform = 'rotateZ(180deg)';
};

const closeSidebar = () => {
  document.getElementsByTagName('aside')[0].classList.remove('side__show');
  document
    .getElementsByTagName('nav')[0]
    .getElementsByTagName('i')[0].style.transform = 'rotateZ(0)';
};
