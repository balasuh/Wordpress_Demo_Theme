import $ from 'jquery';

class Search {
    // 1. Describe and create/initiate our object
    constructor() {
        // this.openButton = document.querySelector('.js-search-trigger'); // you'll use this later
        this.addSearchHTML();
        this.openButton = $(".js-search-trigger");
        this.closeButton = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.searchField = $("#search-term");
        this.resultsDiv = $("#search-overlay__results");
        this.isOverlayOpen = false;
        this.isSpinnerVisible = false;
        this.searchTimer;
        this.events();
    }

    // 2. Events
    events() {
        const {openButton, closeButton, searchField} = this;
        openButton.on('click', this.openOverlay.bind(this)); // Replace this with addEventListener later
        closeButton.on('click', this.closeOverlay.bind(this)); // Replace this with addEventListener later
        $(document).on('keydown', this.keyPressDispatcher.bind(this));
        searchField.on('input', this.searchLogic.bind(this));
    }

    // 3. Methods (function, action, ...)
    openOverlay() {
        const {openButton, closeButton, searchOverlay} = this;
        searchOverlay.addClass("search-overlay--active") //addClass is the jquery variant of .classList.add('') from JS
        //.classList.contains('') and .classList.toggle('') could be efficient options as well
        $("body").addClass("body-no-scroll");
        setTimeout(() => this.searchField.focus(), 301);
        this.searchField.val('');
        this.isOverlayOpen = true;
        // console.log('open');
    }

    closeOverlay() {
        const {openButton, closeButton, searchOverlay} = this;
        searchOverlay.removeClass("search-overlay--active") //addClass is the jquery variant of .classList.remove('') from JS
        //.classList.contains('') and .classList.toggle('') could be efficient options as well
        $("body").removeClass("body-no-scroll");
        this.isOverlayOpen = false;
        // console.log('close');
    }

    keyPressDispatcher(e) {
        // console.log(e.keyCode); // use this to figure out which key corresponds to which code
        if (e.keyCode === 83 && !this.isOverlayOpen && !$("input, textarea").is(':focus')) this.openOverlay(); // 83 corresponds to the key 's'
        if (e.keyCode === 27 && this.isOverlayOpen) this.closeOverlay(); // 27 corresponds to the 'Escape' key
    }

    searchLogic() {
        clearTimeout(this.searchTimer);
        if (this.searchField.val()) {
            if (!this.isSpinnerVisible) {
                this.resultsDiv.html('<div class="spinner-loader"></div>');
                this.isSpinnerVisible = true;
            }
            this.searchTimer = setTimeout(this.getResults.bind(this), 200);
        } else {
            this.resultsDiv.html('');
            this.isSpinnerVisible = false; 
        }
}

    getResults() {
        $.getJSON(universityData.root_url + '/wp-json/university/v1/search?term=' + this.searchField.val(), (results) => {
            this.resultsDiv.html(`
                <div class="row">
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">General Information</h2>
                        ${results.generalInfo.length ? '<ul class="link-list min-list">' : '<p>No general information matches that search.</p>'}
                            ${results.generalInfo.map((post) => 
                                        `<li>
                                                <a href="${post.permalink}">
                                                    ${post.title}
                                                </a>
                                                ${post.postType === 'post' ? `by ${post.authorName}` : ''}
                                            </li>`
                                        ).join('')
                            }       
                ${results.generalInfo.length ? '</ul>' : ''}
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Programs</h2>
                        ${results.programs.length ? '<ul class="link-list min-list">' : `<p>No programs match that search. 
                                                        View <a href='${universityData.root_url}/programs'>all programs.</a></p>`}
                            ${results.programs.map((post) => 
                                        `<li>
                                                <a href="${post.permalink}">
                                                    ${post.title}
                                                </a>
                                            </li>`
                                        ).join('')
                            }       
                ${results.programs.length ? '</ul>' : ''}
                        <h2 class="search-overlay__section-title">Professors</h2>
                        ${results.professors.length ? '<ul class="professor-cards">' : `<p>No professors match that search.`}
                            ${results.professors.map((post) => 
                                                            `
                                                            <li class="professor-card__list-item">
                                                                <a class="professor-card" href='${post.permalink}'>
                                                                    <img src="${post.image}" alt="" class="professor-card__image">
                                                                    <span class="professor-card__name">${post.title}</span>
                                                                </a>
                                                            </li>
                                                            `
                                                    ).join('')
                            }       
${results.professors.length ? '</ul>' : ''}

                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Campuses</h2>
                        ${results.campuses.length ? '<ul class="link-list min-list">' : `<p>No campuses match that search. View 
                                                        <a href='${universityData.root_url}/campuses'>all campuses</a></p>`}
                            ${results.campuses.map((post) => 
                                        `<li>
                                                <a href="${post.permalink}">
                                                    ${post.title}
                                                </a>
                                            </li>`
                                        ).join('')
                            }       
                ${results.campuses.length ? '</ul>' : ''}
                        <h2 class="search-overlay__section-title">Events</h2>
                        ${results.events.length ? '' : `<p>No events match that search. View 
                                                        <a href='${universityData.root_url}/events'>all events</a></p>`}
                            ${results.events.map((post) => 
                                        `
                                        <div class="event-summary">
                                            <a class="event-summary__date t-center" href="${post.permalink}">
                                                <span class="event-summary__month">${post.month}</span>
                                                <span class="event-summary__day">${post.day} </span>
                                            </a>
                                            <div class="event-summary__content">
                                                <h5 class="event-summary__title headline headline--tiny"><a href="${post.permalink}">${post.title}</a></h5>
                                                <p>
                                                    ${post.description} <a href="${post.permalink}"
                                                        class="nu gray">Learn more</a>
                                                </p>
                                            </div>
                                        </div>
                                        `
                                        ).join('')
                            }
                    </div>
                </div>
            `)
            this.isSpinnerVisible = false;
        });
    }

    addSearchHTML() {
        $('body').append(`
        <div class="search-overlay">
            <div class="search-overlay__top">
                <div class="container">
                    <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                    <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term"
                    autocomplete="off">
                    <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
                </div>
            </div>
            <div class="container">
                <div id="search-overlay__results"></div>
            </div>
        </div>
        `);
    }
}

export default Search;
