const searchContainer = document.createElement('div');
    searchContainer.classList.add('search-results-container', 'abs-pos');
    searchContainer.innerHTML = `
        
            <h2>Search Results for "${searchTerm}" <span class="results-count">${results.length} found</span></h2>
            ${resultsHTML}
            ${results.length === 0 ? `
                <div class="no-results">
                    <p>No results found for "${searchTerm}"</p>
                    <p>Try different keywords or browse our categories.</p>
                </div>
            ` : ''}
        
    `;
    root.appendChild(searchContainer);