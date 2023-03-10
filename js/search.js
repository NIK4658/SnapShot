let searchInput = document.getElementById("search-input");
searchInput.oninput = function () {
    getMatchingUsers(searchInput.value);
};

function getMatchingUsers(username) {
    $.post("./post_requests_handler.php", { getMatchingUsers: true, username: username }, function (result) {
        let users = result.users;
        let locations = result.locations;
        let devices = result.devices;
        const searchResultsContainer = document.getElementById("search-results-container");
        searchResultsContainer.innerHTML = "";
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

                searchResultsContainer.appendChild(userContainer);
            });
        }

        if (locations.length > 0) {
            locations.forEach(location => {
                const userContainer = document.createElement("div");
                userContainer.classList.add("user-container");
                const userImage = document.createElement("img");
                userImage.classList.add("user-image");
                userImage.alt = location.name + " profile picture";
                userImage.src = "resources/images/location.png";
                const userLink = document.createElement("a");
                userLink.className = "profile-link";
                userLink.href = "location_device.php?type=location&name=" + location.name;
                userLink.innerText = location.name;
                userContainer.appendChild(userImage);
                userContainer.appendChild(userLink);
                searchResultsContainer.appendChild(userContainer);
            });
        }

        if (devices.length > 0) {
            devices.forEach(device => {
                const userContainer = document.createElement("div");
                userContainer.classList.add("user-container");
                const userImage = document.createElement("img");
                userImage.classList.add("user-image");
                userImage.alt = device.name + " profile picture";
                userImage.src = "resources/images/device.png";
                const userLink = document.createElement("a");
                userLink.className = "profile-link";
                userLink.href = "location_device.php?type=device&name=" + device.name;
                userLink.innerText = device.name;
                userContainer.appendChild(userImage);
                userContainer.appendChild(userLink);
                searchResultsContainer.appendChild(userContainer);
            });
        }
        if (users.length == 0 && locations.length == 0 && devices.length == 0) {
            let noMatchesDiv = document.createElement("div");
            noMatchesDiv.className = "no-matches-found";
            let noMatchesHeader = document.createElement("h2");
            noMatchesHeader.textContent = "Not found";
            noMatchesDiv.appendChild(noMatchesHeader);
            searchResultsContainer.appendChild(noMatchesDiv);
        }
    }, "json");
}
