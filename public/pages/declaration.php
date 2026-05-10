<?php
session_start();

if (!isset($_SESSION['logged'])) {
    header("Location: login.html");
    exit();
}

$user = $_SESSION;
?>

<div class="declaration-header">
    <h2>Mes Déclarations</h2>
    <button class="btn btn-accent" id="addDeclarationBtn">
        <i class="bx bx-plus"></i> Nouvelle déclaration
    </button>
</div>

<div class="declaration-filters">
    <div class="filter-group">
        <input 
            type="text" 
            id="searchReference" 
            placeholder="Rechercher par référence..." 
            class="filter-input"
        >
    </div>
    <div class="filter-group">
        <select id="filterStatus" class="filter-select">
            <option value="">Tous les statuts</option>
            <option value="en_attente">En attente</option>
            <option value="en_cours">En cours</option>
            <option value="accepte">Accepté</option>
            <option value="refuse">Refusé</option>
            <option value="termine">Terminé</option>
        </select>
    </div>
</div>

<div class="declaration-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Référence</th>
                <th>Date Création</th>
                <th>Type</th>
                <th>Soumis</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="declarationList">
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px;">
                    <p style="color: var(--muted);">Chargement des déclarations...</p>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Modal pour créer/éditer une déclaration -->
<div id="declarationModal" class="modal hidden">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3>Nouvelle Déclaration</h3>
            <button class="modal-close" id="closeModal">&times;</button>
        </div>
        <form id="declarationForm" class="modal-form">
            <div class="form-group">
                <label for="reference">Référence</label>
                <input 
                    type="text" 
                    id="reference" 
                    name="reference" 
                    placeholder="REF-2024-001" 
                    required
                >
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select id="type" name="type" required>
                    <option value="">Sélectionner un type</option>
                    <option value="import">Import</option>
                    <option value="export">Export</option>
                    <option value="transit">Transit</option>
                </select>
            </div>
            <div class="form-group">
                <label for="statut">Statut</label>
                <select id="statut" name="statut" required>
                    <option value="en_attente">En attente</option>
                    <option value="accepte">Accepté</option>
                    <option value="refuse">Refusé</option>
                    <option value="termine">Terminé</option>
                </select>
            </div>
            <div class="form-group">
                <label for="date_soumission">Date de soumission</label>
                <input 
                    type="datetime-local" 
                    id="date_soumission" 
                    name="date_soumission"
                >
            </div>
            <div class="form-actions">
                <button type="button" class="btn" id="cancelBtn">Annuler</button>
                <button type="submit" class="btn btn-accent">Soumettre</button>
            </div>
        </form>
    </div>
</div>

<!--
    IMPORTANT SPA :
    Ne pas mettre le <script src="..."> ici via innerHTML car il ne s'exécutera pas.
    Le chargement du script et l'appel à initDeclarationPage() doivent être
    gérés par le routeur SPA. Exemple dans ton routeur :

    async function loadPage(page) {
        const res  = await fetch(`pages/${page}.php`);
        const html = await res.text();
        document.getElementById('main-content').innerHTML = html;

        if (page === 'declaration') {
            await loadScript('../../src/declaration.js');
            window.initDeclarationPage();
        }
    }

    function loadScript(src) {
        return new Promise((resolve) => {
            if (document.querySelector(`script[src="${src}"]`)) {
                resolve(); // déjà chargé, on appelle juste init
                return;
            }
            const s    = document.createElement('script');
            s.src      = src;
            s.onload   = resolve;
            document.body.appendChild(s);
        });
    }
-->