document.getElementById('regForm').addEventListener('submit', async (e) => 
{
    e.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const nom = document.getElementById('nom').value;

    // Appel à l'API PHP
    const response = await fetch('api/auth/register.php', 
    {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ nom, email, password })
    });

    const result = await response.json();
    
    if (response.ok) 
    {
        window.location.replace("accueil.php");
    } 
    else 
    {
        alert(result.error);
    }
});