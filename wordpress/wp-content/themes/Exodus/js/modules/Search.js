import $ from 'jquery';

class Search {
  //describe and create/initiate our project
  constructor() {
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
        this.typingTimer = setTimeout( this.getResults.bind(this) , 2000);

      } else {
        this.resultsDiv.html("");
        this.isSpinnerVisible = false;
      }
    }

    this.previousValue = this.searchField.val();
  }
  getResults() {
  
    $.getJSON('http://localhost/wp-json/wp/v2/posts?search='+ this.searchField.val(), posts => {
      this.resultsDiv.html(`
    <h2 class="search-overlay__section-title"> General Information </h2>
    <ul class="link-list min-list">
      <li><a href="${posts[0].link}"> ${posts[0].title.rendered} </a> </li>
    </ul>

`);
    })
  }
  
  
  keyPressDispatcher(e){
    if(e.keyCode == 83 && ! this.isOverlayOpen && !$("input, textarea").is("focus")){

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
    this.isOverlayOpen = true;
  }

  closeOverlay(){
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    this.isOverlayOpen = false;
  }
}

export default Search;