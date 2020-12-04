// editListing.js
// Shows edit box when clicking edit and changes button to save

function editListing() {
    // Check if we're already editing
    if (document.getElementById("editButton").value === "Edit Listing") {
        document.getElementById("editButton").value = "Save";
        // Swap visibilities of description and edit box
        document.getElementById("itemDesc").style.display = "none";
        document.getElementById("editBox").style.display = "block";
    } else {
        document.getElementById("editForm").submit();
    }
}