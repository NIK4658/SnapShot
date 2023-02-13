import { retrieveImages } from "./utils.js";

const followUnfollowButton = document.getElementById("follow-unfollow-button");
const profileImage = document.getElementById("profile-image").querySelector("img");
const showPostsGridButton = document.getElementById("grid-button");
const showPostsListButton = document.getElementById("list-button");
const profilePosts = document.getElementById("profile-posts");

let limit = 12;
let offset = 0;
let listActive = false;
let gridActive = true;
let intervalIds = [];
let firstLoad = false;

let url = new URL(window.location.href);
let username = url.searchParams.get("username");
let currentUsername = null;
showProfile();


function showProfile() {
  $.post("./post_requests_handler.php", { getProfileData: true, username: username }, function (result) {
    currentUsername = result.currentUsername;
    if (username === null) {
      username = currentUsername;
    }

    showPostsGrid(offset, limit);

    if (currentUsername === username) {
      followUnfollowButton.remove();
      let editProfileDiv = document.getElementById("edit-profile");
      let editProfileLink = document.createElement("a");
      editProfileLink.title = "Edit profile";
      editProfileLink.className = "icon-button";
      editProfileLink.href = "./profile_settings.php";
      let editProfileIcon = document.createElement("span");
      editProfileIcon.className = "fa-regular fa-gear";
      editProfileLink.appendChild(editProfileIcon);
      editProfileDiv.appendChild(editProfileLink);
    } else {
      if (result.profileData.isFollowing) {
        followUnfollowButton.textContent = "Unfollow";
        followUnfollowButton.onclick = unfollow;
      } else {
        followUnfollowButton.textContent = "Follow";
        followUnfollowButton.onclick = follow;
      }
    }

    if (result.profileData.user.profile_image !== null) {
      profileImage.src = "data:image/jpeg;base64," + result.profileData.user.profile_image;
    }

    let usernameParagrah = document.getElementById("username");
    let namePragraph = document.getElementById("name");
    let surnameParagraph = document.getElementById("surname");
    usernameParagrah.textContent = result.profileData.user.username;
    namePragraph.textContent = result.profileData.user.name;
    surnameParagraph.textContent = result.profileData.user.surname;

    let postsNumber = document.getElementById("posts");
    let followersNumber = document.getElementById("followers");
    let followingNumber = document.getElementById("following");
    let followersP = document.getElementById("pFollowers");
    let followingP = document.getElementById("pFollowing");
    postsNumber.textContent = result.profileData.numberPosts;
    followersNumber.textContent = result.profileData.numberFollowers;

    followersP.onclick = function () {
      window.location.href = "./followers.php?username=" + username;
    };

    followingP.onclick = function () {
      window.location.href = "./following.php?username=" + username;
    };

    followingNumber.textContent = result.profileData.numberFollowings;

    let exposureValue = document.getElementById("exposure");
    let colorsValue = document.getElementById("colors");
    let compositionValue = document.getElementById("composition");

  }, "json");
}

function getPostFirstImage(postId) {
  $.post("./post_requests_handler.php", { getPostFirstImage: true, postId: postId }, function (image) {
    let postImage = document.getElementById("post-image-container" + postId);
    if (postImage !== null) {
      postImage.src = "data:image/jpeg;base64," + image;
    }
  }, "json");
}

function follow() {
  $.post("./post_requests_handler.php", { follow: true, username: username });
  followUnfollowButton.textContent = "Unfollow";
  followUnfollowButton.onclick = unfollow;
  location.reload();
}

function unfollow() {
  $.post("./post_requests_handler.php", { unfollow: true, username: username });
  followUnfollowButton.textContent = "Follow";
  followUnfollowButton.onclick = follow;
  location.reload();
}

function showPostsGrid(offset, limit) {
  $.post("./post_requests_handler.php", { getProfilePosts: true, username: username, offset: offset, limit: limit }, function (posts) {
    posts.forEach(post => {
      if (!gridActive) {
        return;
      }
      let postContainer = document.getElementById("grid-post" + post.post_id);
      if (postContainer === null) {
        profilePosts.appendChild(getGridViewPostContainer(post.post_id, post.owner));
        getPostFirstImage(post.post_id);
      }
    });
    firstLoad = true;
  }, "json");
}

function getGridViewPostContainer(postId, owner) {
  let postContainer = document.createElement("div");
  postContainer.className = "grid-post";
  postContainer.id = "grid-post" + postId;

  let imageDiv = document.createElement("div");
  imageDiv.className = "post-image-container";
  let postImage = document.createElement("img");
  postImage.id = "post-image-container" + postId;
  postImage.alt = "Post image";


  imageDiv.onclick = function () {
    window.location.href = "./post.php?postId=" + postId;
  };

  if (owner === currentUsername) {
    let deleteButton = document.createElement("button");
    deleteButton.className = "icon-button delete-button";
    deleteButton.id = "delete-button" + postId;
    deleteButton.type = "button";
    let deleteButtonIcon = document.createElement("span");
    deleteButtonIcon.className = "fa-regular fa-trash-alt";
    deleteButton.appendChild(deleteButtonIcon);
    deleteButton.onclick = function () {
      deletePost(postId);
    };
    imageDiv.appendChild(deleteButton);
  }

  imageDiv.appendChild(postImage);
  postContainer.appendChild(imageDiv);

  return postContainer;
}

function deletePost(postId) {
  $.post("./post_requests_handler.php", { deletePost: true, postId: postId }, function () {
    let postContainer = document.getElementById("grid-post" + postId);
    postContainer.remove();
    let postsNumber = document.getElementById("posts");
    postsNumber.textContent = parseInt(postsNumber.textContent) - 1;
  });
}

window.onscroll = function () {
  if (firstLoad && window.innerHeight + window.pageYOffset >= document.body.offsetHeight) {
    offset += limit;
    if (gridActive) {
      showPostsGrid(offset, limit);
    } else {
      showPostsList(offset, limit);
    }
  }
};
