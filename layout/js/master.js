let up = document.querySelector(".up")
window.onscroll = () => {
    this.scrollY >= 500 ? up.classList.add("show") : up.classList.remove("show")
}
up.onclick = () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
}

let butNav = document.querySelector("header .dots");
let links = document.querySelector("header .links");
butNav.addEventListener("click", e => {
    e.stopPropagation();
});
links.addEventListener("click", e => {
    e.stopPropagation();
});
butNav.addEventListener('click', e => {
    butNav.classList.toggle('active');
    links.classList.toggle('active');
});
document.addEventListener('click', e => {
    if (e.target != butNav || e.target!= links) {
        butNav.classList.remove('active');
        links.classList.remove('active');
    }
});