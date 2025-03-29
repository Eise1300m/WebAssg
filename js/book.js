// Star Rating System
document.addEventListener('DOMContentLoaded', function() {
    initializeStarRating();
});

function initializeStarRating() {
    const starLabels = document.querySelectorAll('.stars-container label');
    const starInputs = document.querySelectorAll('.stars-container input');
    
    starLabels.forEach(label => {
        // Create star image element with the correct filename
        const starImg = document.createElement('img');
        starImg.src = '../upload/icon/star-empty.png'; // Using your filename
        starImg.alt = 'Star';
        starImg.className = 'star-icon';
        
        // Replace the existing <i> element with our new image
        const existingIcon = label.querySelector('i');
        if (existingIcon) {
            existingIcon.replaceWith(starImg);
        } else {
            label.appendChild(starImg);
        }

        // Change to filled star on hover
        label.addEventListener('mouseenter', function() {
            this.querySelector('.star-icon').src = '../upload/icon/star-filled.png';
            let prevSibling = this.previousElementSibling;
            
            // Also change all previous stars
            while (prevSibling && prevSibling.tagName === 'LABEL') {
                prevSibling.querySelector('.star-icon').src = '../upload/icon/star-filled.png';
                prevSibling = prevSibling.previousElementSibling;
            }
        });
        
        // Return to default state on mouseout
        label.addEventListener('mouseleave', function() {
            resetStars();
        });
    });
    
    // Keep the selected stars filled
    starInputs.forEach(input => {
        input.addEventListener('change', function() {
            resetStars();
        });
    });
}

// Function to reset stars based on the selected rating
function resetStars() {
    const starLabels = document.querySelectorAll('.stars-container label');
    const starInputs = document.querySelectorAll('.stars-container input');
    let selectedRating = 0;
    
    starInputs.forEach(input => {
        if (input.checked) {
            selectedRating = parseInt(input.value);
        }
    });
    
    starLabels.forEach(label => {
        const starValue = parseInt(label.getAttribute('for').replace('star', ''));
        const starImg = label.querySelector('.star-icon');
        
        if (starValue <= selectedRating) {
            starImg.src = '../upload/icon/star-filled.png';
        } else {
            starImg.src = '../upload/icon/star-empty.png'; // Using your filename
        }
    });
}
