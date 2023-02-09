import { retrieveLikesNumber } from "./utils.js";
import { retrieveComments } from "./utils.js";
import { retrieveImages } from "./utils.js";

let url = new URL(window.location.href);
getSinglePost(url.searchParams.get("postId"));

function getSinglePost(postid) {
    $.post("./post_requests_handler.php", { getPost: true, postid: postid }, function (post) {
        let postDiv;
        console.log(post[0].post_id);
        console.log(post[0].owner);
        const MainPageDiv = document.getElementById("post-page");
        if (post != 0) {
            postDiv = getPostContainer(post[0].post_id, post[0].username, post[0].caption, post[0].liked, post[0].rated);
            MainPageDiv.appendChild(postDiv);
            retrieveImages(post[0].post_id);
            retrieveLikesNumber(post[0].post_id);
            //DA FIXARE
            retrieveComments(post[0].post_id, post[0].currentUsername);
            setInterval(function () {
                retrieveLikesNumber(post[0].post_id);
            }, 1000);
            setInterval(function () {
                retrieveComments(post[0].post_id, post[0].currentUsername);
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
        }
    }, "json");
}
