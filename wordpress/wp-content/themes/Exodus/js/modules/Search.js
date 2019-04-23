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

    $.getJSON(universityData.root_url + '/wp-json/university/v1/search?term='+ this.searchField.val(), (results) => {


      // results is from getJSON 2nd parameter (ex: ${results.generalInfo.length ?) 
      // its value is from 1st parameter of getJSON [location]
      // results.generalInfo - I mean generalInfo is from the API we create on inc/search-route.js 
      // item.link before now on our new API we will use item.permalink and item.title
      //its because its the structure of our newly created API 
      this.resultsDiv.html(`
<div class="row">
<div class="one-third">
<h2 class="search-overlay__section-title"> General Information </h2>
${results.generalInfo.length ? '<ul class="link-list min-list">' : '<p> No results found </p>'}

${results.generalInfo.map( item => `<li><a href="${item.permalink}">  ${item.title} </a>
${ item.postType == 'post' ? `by ${item.authorName}`: ``  }  </li>` ).join('')}

${results.generalInfo.length ? '</ul>' : '' }


</div>
<div class="one-third">
<h2 class="search-overlay__section-title"> Programs </h2>        
${results.programs.length ? '<ul class="link-list min-list">' : '<p> No results found </p>'}

${results.programs.map( item => `<li><a href="${item.permalink}">  ${item.title} </a> `).join('')}

${results.programs.length ? '</ul>' : '' }



<h2 class="search-overlay__section-title"> Professors </h2>
${results.professors.length ? '<ul class="link-list min-list">' : `<p>View  </p> <a href="${universityData.root_url}/programs"> all Professors </a> `}

${results.professors.map( item => `<li><a href="${item.permalink}">  ${item.title} </a>` ).join('')}

${results.professors.length ? '</ul>' : `` }





</div>
<div class="one-third">
<h2 class="search-overlay__section-title"> Campuses </h2>


${results.professors.length ? '<ul class="link-list min-list">' : '<p> No results found </p>'}

${results.professors.map( item => `<li><a href="${item.permalink}">  ${item.title} </a>
${ item.postType == 'post' ? `by ${item.authorName}`: ``  }  </li>` ).join('')}

${results.professors.length ? '</ul>' : '' }



<h2 class="search-overlay__section-title"> Events </h2>


${results.professors.length ? '<ul class="link-list min-list">' : '<p> No results found </p>'}

${results.professors.map( item => `<li><a href="${item.permalink}">  ${item.title} </a>
${ item.postType == 'post' ? `by ${item.authorName}`: ``  }  </li>` ).join('')}

${results.professors.length ? '</ul>' : '' }


</div>
</div>


`)

    } ); this.isSpinnerVisible = false;

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