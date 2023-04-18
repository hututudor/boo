export const registerSidebarEvents = () => {
  const button = document
    .getElementsByTagName('nav')[0]
    .getElementsByTagName('button')[0];

  button.addEventListener('click', handleSidebarOpenClose);
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
