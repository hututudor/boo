document.addEventListener('DOMContentLoaded', registerSidebarEvents);

function isSidebarOpen() {
  return document
    .getElementsByTagName('aside')[0]
    .classList.contains('side__show');
}

function registerSidebarEvents() {
  const button = document
    .getElementsByTagName('nav')[0]
    .getElementsByTagName('button')[0];

  button.addEventListener('click', handleSidebarOpenClose);
}

function handleSidebarOpenClose() {
  if (isSidebarOpen()) {
    closeSidebar();
  } else {
    openSidebar();
  }
}

function openSidebar() {
  document.getElementsByTagName('aside')[0].classList.add('side__show');
  document
    .getElementsByTagName('nav')[0]
    .getElementsByTagName('i')[0].style.transform = 'rotateZ(180deg)';
}

function closeSidebar() {
  document.getElementsByTagName('aside')[0].classList.remove('side__show');
  document
    .getElementsByTagName('nav')[0]
    .getElementsByTagName('i')[0].style.transform = 'rotateZ(0)';
}
