
const profileImage = document.getElementById("profile-image").querySelector("img");
const profilePosts = document.getElementById("profile-posts");

let limit = 12;
let offset = 0;
let listActive = false;
let gridActive = true;
let intervalIds = [];
let firstLoad = false;

let url = new URL(window.location.href);
let username = url.searchParams.get("name");
let type = url.searchParams.get("type");
let currentUsername = null;
showProfile();


function showProfile() {
    showPostsGrid(offset, limit);
    profileImage.src = "resources/images/blank_profile_picture.jpeg";
    let usernameParagrah = document.getElementById("username");
    usernameParagrah.textContent = username;
}

function getPostFirstImage(postId) {
  $.post("./post_requests_handler.php", { getPostFirstImage: true, postId: postId }, function (image) {
    let postImage = document.getElementById("post-image-container" + postId);
    if (postImage !== null) {
      postImage.src = "data:image/jpeg;base64," + image;
    }
  }, "json");
}

function showPostsGrid(offset, limit) {
  $.post("./post_requests_handler.php", { getLocationOrDevicePosts: true, type: type, username: username, offset: offset, limit: limit }, function (posts) {
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
  imageDiv.appendChild(postImage);
  postContainer.appendChild(imageDiv);
  return postContainer;
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
