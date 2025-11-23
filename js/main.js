import { stickyNavbar } from "./navbar.js";
import { toggleSidebar } from "./sidebar.js";

// Navbar scroll behavior
window.addEventListener("scroll", () => {
  if (window.scrollY > 50) {
    stickyNavbar(true);   
  } else {
    stickyNavbar(false); 
  }
});

// Run toggle Function

// Open Toggle
const openToggle = document.getElementById('openToggle'); 
openToggle.addEventListener('click', (e)=> {
    e.preventDefault(); 
    toggleSidebar(); 
});

// Close Toggle
const closeToggle = document.getElementById('closeToggle');
closeToggle.addEventListener('click', (e)=> {
    e.preventDefault(); 
    toggleSidebar(); 
});

