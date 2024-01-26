document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('YOUR_FILE_INPUT_ID');
    const fileInputLabel = document.getElementById('YOUR_LABEL_ID');
    const originalFilenameDiv = document.getElementById('currentPhoto');

    if (fileInput.value === '') {
        fileInputLabel.textContent = originalLabel;
        originalFilenameDiv.style.display = 'none';
    } else {
        const realPathArray = fileInput.value.split('\\');
        const newFileName = realPathArray[realPathArray.length - 1];
        fileInputLabel.textContent = 'Current file: ' + newFileName;

        // Update the originalFilename div to reflect the newly selected file
        originalFilenameDiv.textContent = 'Original file: ' + newFileName;
        originalFilenameDiv.style.display = 'block';
    }
});
