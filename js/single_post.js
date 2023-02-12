import { retrieveLikesNumber } from "./utils.js";
import { retrieveComments } from "./utils.js";
import { retrieveImages } from "./utils.js";

let url = new URL(window.location.href);
getSinglePost(url.searchParams.get("postId"));

function getSinglePost(postid) {
    $.post("./post_requests_handler.php", { getPost: true, postid: postid }, function (result) {
        let postDiv;
        let post = result.post;
        let currentUsername = result.currentUsername;
        const MainPageDiv = document.getElementById("post-page");
        console.log(post[0].location);
        console.log(post[0].device);
        if (post != 0) {
            postDiv = getPostContainer(post[0].post_id, post[0].username, post[0].caption, result.isLiked, post[0].rated, post[0].location, post[0].device);
            MainPageDiv.appendChild(postDiv);
            retrieveImages(post[0].post_id);
            retrieveLikesNumber(post[0].post_id);
            retrieveComments(post[0].post_id, currentUsername);
            setInterval(function () {
                retrieveLikesNumber(post[0].post_id);
            }, 1000);
            setInterval(function () {
                retrieveComments(post[0].post_id, currentUsername);
            }, 1000);
            showCommentsDiv(post[0].post_id);
        } else {
            MainPageDiv.innerHTML = "";
            let noPostsDiv = document.createElement("div");
            noPostsDiv.className = "no-matches-found";
            let noPostsHeader = document.createElement("h2");
            noPostsHeader.textContent = "An Error Occurred!";
            noPostsHeader.style.textAlign = "center";
            let noPostsIcon = document.createElement("span");
            noPostsIcon.className = "fa-regular fa-face-frown-slight";
            noPostsDiv.appendChild(noPostsHeader);
            noPostsDiv.appendChild(noPostsIcon);
            MainPageDiv.appendChild(noPostsDiv);
            history.go(-1);
        }
    }, "json");
}
