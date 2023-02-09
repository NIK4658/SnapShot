import { showUsers } from "./utils.js";

let url = new URL(window.location.href);
getPostLikesPeople(url.searchParams.get("post"));

function getPostLikesPeople(postid) {
    $.post("./post_requests_handler.php", { getPostLikesPeople: true, postid: postid }, function (users) {
        const followingContainer = document.getElementById("people-page");
        showUsers(users, followingContainer);
    }, "json");
}
