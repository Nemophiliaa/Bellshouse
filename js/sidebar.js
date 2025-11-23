// Toggle Function

export const toggleSidebar = () => {
    const sidebar = document.getElementById('sidebar'); 

    // ADD NEW CLASS    
    if(sidebar.classList.contains('translate-x-full')) {
        sidebar.classList.remove('translate-x-full'); 
        sidebar.classList.add('translate-x-0'); 
    }else {
        sidebar.classList.remove('translate-x-0')
        sidebar.classList.add('translate-x-full')
    }
}