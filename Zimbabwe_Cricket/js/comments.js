document.addEventListener("DOMContentLoaded", () => { 
    const form = document.getElementById("commentform");
    const commentsDiv = document.getElementById("comments");
    const errorDiv = document.getElementById("errorMessages"); // Add an element to display error messages

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        const formData = new FormData(form);

        try {
            const response = await fetch("comments.php", {
                method: "POST",
                body: formData,
            });

            const data = await response.json();

            if (data.error) {
                
                errorDiv.innerHTML = `<p style="color: red;">${data.error}</p>`;
            } else if (data.success) {
                
                errorDiv.innerHTML = ''; 
                loadComments();
                form.reset();
            }
        } catch (error) {
            
            errorDiv.innerHTML = `<p style="color: red;">An error occurred: ${error.message}</p>`;
        }
    });

    async function loadComments() {
        const response = await fetch("comments.php");
        if (response.ok) {
            const comments = await response.json();
            commentsDiv.innerHTML = comments
                .map(
                    (comment) =>
                        `<div>
                            <h3>${comment.name}</h3>
                            <p>${comment.comment}</p>
                            <small>${new Date(comment.created_at).toLocaleString()}</small>
                        </div>`
                )
                .join("");
        } else {
            commentsDiv.innerHTML = "Failed to load comments.";
        }
    }

    loadComments();
});
