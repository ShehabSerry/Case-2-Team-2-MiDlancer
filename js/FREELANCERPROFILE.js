// Preview image
function previewImage(event) {
    const image = document.getElementById('image-preview');
    image.src = URL.createObjectURL(event.target.files[0]);
}

// Submit form function (placeholder)
function submitForm() {
    alert('Form submitted!');
}

// Toggle archive status (placeholder)
function toggleArchive() {
    alert('Archive/Unarchive toggled!');
}

// Show add skill popup
function showAddSkillPopup() {
    document.getElementById('add-skill-popup').style.display = 'flex';
}

// Close add skill popup
function closeAddSkillPopup() {
    document.getElementById('add-skill-popup').style.display = 'none';
}

// Add skill (placeholder)
function addSkill() {
    const skill = document.getElementById('new-skill').value;
    alert('Skill added: ' + skill);
    closeAddSkillPopup();
}
