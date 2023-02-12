function retrieveImages(postId) {
    $.post("./post_requests_handler.php", { getPostImages: true, postId: postId }, function (images) {
        let postImagesDiv = document.getElementById("post-image-container" + postId);

        if (postImagesDiv !== null) {
            if (images.length > 1) {
                let indexDiv = document.createElement("div");
                indexDiv.className = "slide-index";
                indexDiv.id = "slide-index" + postId;
                let indexParagraph = document.createElement("p");
                indexParagraph.id = "index" + postId;
                indexParagraph.textContent = "1/" + images.length;
                indexDiv.appendChild(indexParagraph);
                postImagesDiv.appendChild(indexDiv);
            }

            for (let i = 0; i < images.length; i++) {
                let postImageSlide = document.createElement("img");
                postImageSlide.className = "post-image-slide";
                postImageSlide.id = "post-image-slide" + postId + i;
                postImageSlide.src = "data:image/jpeg;base64," + images[i];
                postImageSlide.alt = "Post image " + i;
                postImageSlide.hidden = i != 0;
                postImagesDiv.appendChild(postImageSlide);
            }

            if (images.length > 1) {
                let arrowButtonsDiv = document.createElement("div");
                arrowButtonsDiv.className = "arrow-buttons-div";
                let leftArrowButton = document.createElement("button");
                leftArrowButton.className = "icon-button post-button arrow-button";
                leftArrowButton.id = "previous-slide-button" + postId;
                leftArrowButton.type = "button";
                let leftArrowButtonIcon = document.createElement("span");
                leftArrowButtonIcon.className = "fa-regular fa-arrow-left";
                leftArrowButton.appendChild(leftArrowButtonIcon);
                leftArrowButton.onclick = function () {
                    showSlideLeft(postId);
                };
                let rightArrowButton = document.createElement("button");
                rightArrowButton.className = "icon-button post-button arrow-button";
                rightArrowButton.id = "next-slide-button" + postId;
                rightArrowButton.type = "button";
                let rightArrowButtonIcon = document.createElement("span");
                rightArrowButtonIcon.className = "fa-regular fa-arrow-right";
                rightArrowButton.appendChild(rightArrowButtonIcon);

                rightArrowButton.onclick = function () {
                    showSlideRight(postId);
                };
                arrowButtonsDiv.appendChild(leftArrowButton);
                arrowButtonsDiv.appendChild(rightArrowButton);
                postImagesDiv.appendChild(arrowButtonsDiv);

            }
        }
    }, "json");
}

function retrieveLikesNumber(postId) {
    $.post("./post_requests_handler.php", { getPostLikesNumber: true, postId: postId }, function (likesNumber) {
        let likesNumberTag = document.getElementById("likes-number" + postId);
        likesNumberTag.textContent = likesNumber;
    }, "json");
}

function retrieveComments(postId, currentUsername) {
    let postCommentsDiv = document.getElementById("post-comments" + postId);
    if (!postCommentsDiv.hidden) {
        $.post("./post_requests_handler.php", { getPostComments: true, postId: postId }, function (comments) {
            getCommentsContainer(postId, postCommentsDiv, comments, currentUsername);
        }, "json");
    }
}

function showUsers(users, container){
    if (users.length > 0) {
        users.forEach(user => {
            const userContainer = document.createElement("div");
            userContainer.classList.add("user-container");

            const userImage = document.createElement("img");
            userImage.classList.add("user-image");
            userImage.alt = user.username + " profile picture";
            if (user.profile_image != null) {
                userImage.src = "data:image/jpeg;base64," + user.profile_image;
            } else {
                userImage.src = "resources/images/blank_profile_picture.jpeg";
            }

            const userLink = document.createElement("a");
            userLink.className = "profile-link";
            userLink.href = "profile.php?username=" + user.username;
            userLink.innerText = user.username;

            userContainer.appendChild(userImage);
            userContainer.appendChild(userLink);

            container.appendChild(userContainer);
        });
    } else {
        let noMatchesDiv = document.createElement("div");
        noMatchesDiv.className = "no-matches-found";
        let noMatchesHeader = document.createElement("h2");
        noMatchesHeader.textContent = "No results found";
        noMatchesDiv.appendChild(noMatchesHeader);
        container.appendChild(noMatchesDiv);
    }

}

function showSnackbar(message) {
    var snackbar = document.getElementById("snackbar");
    snackbar.className = "show";
    snackbar.innerText = message;
    setTimeout(function () {
        snackbar.className = snackbar.className.replace("show", "");
    }, 3000);
}

export { retrieveLikesNumber, retrieveComments, retrieveImages, showUsers, showSnackbar };
