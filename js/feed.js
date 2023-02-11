import { retrieveLikesNumber } from "./utils.js";
import { retrieveComments } from "./utils.js";
import { retrieveImages } from "./utils.js";

let postsNumber = 0;
let offset = 0;
let limit = 3;

export function getFeedPosts(offset, limit) {
    $.post("./post_requests_handler.php", { getFeedPosts: true, offset: offset, limit: limit }, function (result) {
        let postDiv;
        const homePageDiv = document.getElementById("home-page");
        if (offset === 0) {
            postsNumber = result.posts.length;
        } else {
            postsNumber += result.posts.length;
        }
        result.posts.forEach(post => {
            postDiv = getPostContainer(post.post_id, post.owner, post.caption, post.liked, post.rated);
            homePageDiv.appendChild(postDiv);
            retrieveImages(post.post_id);
            retrieveLikesNumber(post.post_id);
            retrieveComments(post.post_id, result.currentUsername);
            setInterval(function () {
                retrieveLikesNumber(post.post_id);
            }, 1000);
            setInterval(function () {
                retrieveComments(post.post_id, result.currentUsername);
            }, 1000);
        });

        if (postsNumber === 0) {
            homePageDiv.innerHTML = "";
            let noPostsDiv = document.createElement("div");
            noPostsDiv.className = "no-matches-found";
            let noPostsHeader = document.createElement("h2");
            noPostsHeader.textContent = "Follow someone first and then come back!";
            noPostsHeader.style.textAlign = "center";
            // let noPostsIcon = document.createElement("span");
            // noPostsIcon.className = "fa-regular fa-face-frown-slight";
            noPostsDiv.appendChild(noPostsHeader);
            // noPostsDiv.appendChild(noPostsIcon);
            homePageDiv.appendChild(noPostsDiv);
        }
    }, "json");
}

window.onscroll = function () {
    if (window.innerHeight + window.pageYOffset >= document.body.offsetHeight) {
        offset += limit;
        getFeedPosts(offset, limit);
    }
};
