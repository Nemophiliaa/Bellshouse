//  NAVBAR FUNCTION 

export const stickyNavbar = (isSticky) => {
  const navbar = document.getElementById('stickyNavbar');
  
  // ADD CLASS LIST   
  if (isSticky) {
    navbar.classList.add('bg-slate-200', 'shadow-md', '!fixed', 'left-0', 'right-0');
  } else {
    navbar.classList.remove('bg-slate-200', 'shadow-md', '!fixed', 'left-0' , 'right-0');
  }
};
