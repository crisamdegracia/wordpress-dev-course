import $ from 'jquery';


class Search {
  //describe and create/initiate our project
  constructor() {
    this.addSearchHTML();
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.searchField = $("#search-term");
    this.resultsDiv  = $("#search-overlay__results");
    this.events();
    this.isOverlayOpen = false;
    this.typingTimer;
    this.isSpinnerVisible = false;
    this.previousValue; 
  }

  //events
  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));
    $(document).on("keydown", this.keyPressDispatcher.bind(this));
    this.searchField.on("keyup", this.typingLogic.bind(this));
  }

  // methods
  //when user starts to press down keys
  typingLogic(){

    // if the current searchValue is not equal of the previous value 
    // the timeout and spinner will run
    if( this.searchField.val() != this.previousValue ) {
      clearTimeout(this.typingTimer);

      if ( this.searchField.val() ){

        if( !this.isSpinnerVisible ){
          this.resultsDiv.html('<div class="spinner-loader"></div>');
          this.isSpinnerVisible =  true;
        }
        this.typingTimer = setTimeout( this.getResults.bind(this) , 500);

      } else {
        this.resultsDiv.html("");
        this.isSpinnerVisible = false;
      }
    }

    this.previousValue = this.searchField.val();
  }



  getResults() {
    // Asynchronous style JS -- 
    //on  when() we can use many JSON request as we want
    //and it will all run asynchronous 
    $.when(
      // 1st argument -- can have many argument 
      //normaly we pass two  argment LOCATION and FUNCTION on JSON but
      // on when() method its okay to be one. coz we use then()
      $.getJSON(universityData.root_url + '/wp-json/wp/v2/posts?search='+ this.searchField.val()),

      // 2nd argument  
      $.getJSON(universityData.root_url + '/wp-json/wp/v2/pages?search='+ this.searchField.val())

      //when all JSON request are complete it will run
      //anonymous function using ES6 
      // every request from when() will match the pagkasunod sunod ng
      // parameter ex.  when(a,b,c) is then(a,b,c)
      //using posts and pages we can output request from JSON
    ).then((posts, pages) => {
      // we combined 2 array by using concat()
      // posts[0] - is becoz we only use the first item in many array information
      // giving the when() and then() method
      // we only use the first array of information
      //the first item is the first JSON data
      //2nd is whether it fail or succeded
      var combinedResults = posts[0].concat(pages[0]);

      //outputing on the HTML
      this.resultsDiv.html(`
<h2 class="search-overlay__section-title"> General Information </h2>

${combinedResults.length ? '<ul class="link-list min-list">' : '<p> No results found </p>'}

${combinedResults.map( item => `<li><a href="${item.link}">  ${item.title.rendered} </a> ${ item.type == 'post' ? `by ${item.authorName}`: ``  }  </li>` ).join('')}


${combinedResults.length ? '</ul>' : '' }

`)
    }, () => {
      this.resultsDiv.html('<p> Unexpected Error. Please try again! </p>')
    });
    this.isSpinnerVisible = false;
  }


  keyPressDispatcher(e){
    if(e.keyCode == 83 && ! this.isOverlayOpen && !$("input, textarea").is("focus") ){

      this.openOverlay();
      console.log('open overlay');
    }
    if(e.keyCode == 27 && this.isOverlayOpen){
      this.closeOverlay();
      console.log('close overlay');

    }
  }

  openOverlay(){
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass("body-no-scroll");
    this.searchField.val('');
    setTimeout(() => this.searchField.focus(), 301  );
    this.isOverlayOpen = true;
  }

  closeOverlay(){
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    this.isOverlayOpen = false;
  }


  addSearchHTML(){

    $("body").append(`


<div class="search-overlay">
<div class="search-overlay__top">
<div class="container">
<i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
<input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
<i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
</div>
</div>

<div class="container">
<div id="search-overlay__results">

</div>
</div>
</div>

`)


  }


}

export default Search;