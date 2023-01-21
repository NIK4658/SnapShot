import asyncRequest from "./asyncRequest.js";
const args = { 'offset': 0 };

window.onscroll = function () {
    if(window.innerHeight + window.scrollY >= document.body.offsetHeight) {
        asyncRequest('post.php', (response) => {
        let npost = Object.assign(document.createElement('p'), {innerText: response[0].n_posts});
        document.getElementById('posts').appendChild(npost);
        console.log(response);
        }, args);
    }
};