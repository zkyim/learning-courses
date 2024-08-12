let sidebar = Array.from(document.querySelectorAll('.sidebar > ul > li'));
let content = Array.from(document.querySelectorAll('.container-content > div'));

sidebar.forEach( (e, index) => {
    e.addEventListener('click', ele => {
        sidebar.forEach( e => {e.classList.remove('active');});
        e.classList.add('active');
        content.forEach( e => {e.classList.remove('active');});
        content[index].classList.add('active');
    });
});