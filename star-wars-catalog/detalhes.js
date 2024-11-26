document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    
    const link = document.createElement('link');
    link.rel = 'preload';
    link.href = `backend/index.php?endpoint=detalhes-filme&id=${id}`;
    link.as = 'fetch';
    link.crossOrigin = 'same-origin'; 
    document.head.appendChild(link);

 
    fetch(`backend/index.php?endpoint=detalhes-filme&id=${id}`, {
        credentials: 'same-origin' 
    })
    .then(response => {
        if (!response.ok) throw new Error("Erro ao carregar filme");
        return response.json();
    })
    .then(filme => {
        const container = document.getElementById('detalhes-container');

        if (!filme.title) {
            container.innerHTML = '<p>Detalhes do filme não disponíveis.</p>';
            return;
        }

        container.innerHTML = `
            <h2>${filme.title}</h2>
            <p>Nº Episódio: ${filme.episode_id ?? 'N/A'}</p>
            <p>Sinopse: ${filme.opening_crawl ?? 'Sinopse indisponível'}</p>
            <p>Data de lançamento: ${filme.release_date}</p>
            <p>Diretor: ${filme.director}</p>
            <p>Produtor(es): ${filme.producer}</p>
            <h3>Personagens:</h3>
            <p id="characters-list">${filme.characters && filme.characters.length > 0 ? '' : 'Personagens não disponíveis para este filme.'}</p>
        `;

        const characterList = document.getElementById('characters-list');

      
        if (filme.episode_id <= 6) {
            const characterPromises = filme.characters
                .filter(url => url)
                .map(url => fetch(url).then(res => res.json()).catch(() => ({ name: 'Personagem não encontrado' })));

            Promise.all(characterPromises)
                .then(apiCharacters => {
                    const apiCharacterNames = apiCharacters.map(character => character.name || 'Personagem não encontrado');
                    characterList.textContent = apiCharacterNames.join(', ');
                })
                .catch(() => {
                    characterList.textContent = 'Erro ao carregar personagens da API.';
                });
        } else {
            
            const manualCharacters8 = [
                "Rey", "Finn", "Ben Solo/Kylo Ren", "Luke Skywalker", "Leia Organa", "Poe Dameron", "Maz Kanata", "General Hux", "Capitã Phasma", "Líder Supremo Snoke", "C-3PO", "Rose Tico", "Vice-Almirante Amilyn Holdo", "DJ", "Chewbacca", "Snap Wexley", "Tenente Connix", "Almirante Ackbar", "R2-D2", "Nien Nunb", "Yoda"

             
            ];

            const manualCharacters9 = [
                "General Hux", "C-3PO", "Maz Kanata", "Beaumont", "Rose Tico", "Lieutenant Connix", "Chewbacca", "Jannah", "Palpatine", "General Pryde", "Snap Wexley", "General Quinn", "Wedge Antilles", "Admiral Griss", "Babu Frik", "Lieutenant Garam", "General Parnadee", "Snoke", "Mutter von Rey", "Commander D'Acy", "Vater von Rey", "Officer Kandia", "Han Solo", "Soldat", "Commander Trach", "Boolie", "Nambi Ghima", "Pilot Vanik", "Pilot Tyce", "Nien Nunb", "Wicket W. Warrick", "JOma Tres", "FN-1226", "Demine Lithe", "Young Rey", "Kannan Jarus"

                
            ];

            if (filme.episode_id === 8) {
                characterList.textContent = manualCharacters8.join(', ');
            } else if (filme.episode_id === 9) {
                characterList.textContent = manualCharacters9.join(', ');
            } else {
                const manualCharacters7 = [
                    "Anakin Skywalker", "Andrithal Robb-Voti", "Athgar Heece", "Bazine Netal", 
        "BB-8", "B-U4D", "Bobbajo", "Brasmon Kee", "C-3PO", "Caluan Ematt", 
        "Cherff Maota", "Chewbacca", "Connix", "Cratinus", "Crokind Sand", 
        "Dasha Promenti", "Ello Asty", "Finn", "GA-97", "Gial Ackbar", 
        "Goss Toowers", "Gwellis Bagnoro", "Grumgarr", "Han Solo", "Hux", 
        "Jashco Phurus", "Jessika Pava", "Kylo Ren", "Korr Sella", 
        "Lanever Villecham", "Leia Organa", "Lor San Tekka", "Luke Skywalker", 
        "Maz Kanata", "ME-8D9", "Munduri", "Nahani Gillen", "Nien Nunb", 
        "Phasma", "Poe Dameron", "Prashee", "Praster Ommlen", 
        "Pru Sweevant", "Quiggold", "PZ-4CO", "R2-D2", "Razoo Qin-Fee", 
        "Rey", "Roodown", "Sarco Plank", "Sidon Ithano", "Snoke", 
        "Sonsigo", "Tasu Leech", "Teedo", "Temmin Wexley", 
        "Thandlé Berenko", "Thanlis Depallo", "Unkar Plutt", "Wollivan", "Zuvio"
                    
                ];
                characterList.textContent = manualCharacters7.join(', ');
            }
        }
    })
    .catch(error => {
        const container = document.getElementById('detalhes-container');
        container.innerHTML = '<p>Erro ao carregar os detalhes do filme.</p>';
    });
});
