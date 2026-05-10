document.getElementById('logForm').addEventListener('submit', async (e) => 
{
    e.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Appel à l'API PHP
    const response = await fetch('api/auth/login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password })
    });

    const result = await response.json();
    
    if (response.ok) {
        window.location.replace("accueil.php");
    } else {
        // Afficher le message d'erreur à l'utilisateur
        alert(result.error); // ou mieux, un élément HTML dédié
    }
});