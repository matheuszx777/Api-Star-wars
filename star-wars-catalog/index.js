document.addEventListener('DOMContentLoaded', () => {
    fetch('backend/index.php?endpoint=listar-filmes')
        .then(response => response.json())
        .then(data => {
            console.log(data); 
            const container = document.getElementById('filmes-container');
            data.forEach(filme => {
               
                let imgFileName = filme.title.toLowerCase().replace(/\s+/g, '-').replace(/[^\w-]+/g, '') + '.jpg';
                let imgSrc = `assets/images/${imgFileName}`;

             
                let filmId;
if (filme.url.includes('https://swapi.dev')) {
    filmId = filme.url.match(/\/([0-9]+)\/$/)[1];
} else {
    
    filmId = filme.episode_id;
}

                
                const div = document.createElement('div');
                div.className = 'filme';
                div.innerHTML = `
                    <h2>${filme.title}</h2>
                    <img src="${imgSrc}" alt="${filme.title}" style="width:200px; height:auto;">
                    <p class="data-lancamento">Data de lançamento: ${filme.release_date}</p>
                    <a href="detalhes.html?id=${filmId}" class="button">Ver detalhes</a>
                `;
                container.appendChild(div);
            });
        })
        .catch(error => console.error("Erro ao carregar filmes:", error));
});
