//TODO Make a UWAA object and clear bind this there?.
Isotope = Backbone.View.extend({
    el: '#isotope-canvas',


  events: {
    "click .filter-button" : "filterByButton",
    "keyup #quicksearch" : "filterBySearch",
    "click .list-button" : "listView",
    "click .grid-button" : "tileView",
    "click .print-button" : "print",

  },

  initialize: function() {
    $canvas = this.$('.isotope').isotope({
      itemSelector: '.post-thumbnail-slide',
      layoutMode: 'fitRows'
    });

    $canvas.imagesLoaded(function() {
      $canvas.isotope('layout');
    })
  },


  filterByButton: function(e) {
    var $target = $(e.target);
    this.$('#quicksearch').val('');
    var filterValue = $target.attr('data-filter'); 
    this.$('.isotope').isotope({filter: filterValue});    
    this.toggleButtonClass($target);
  },

  toggleButtonClass: function(target) {
    target.siblings().removeClass('is-checked');
    target.addClass('is-checked');
  },

  toggleParentButtonClass: function(target) {
    target.parent().siblings().removeClass('is-checked');
    target.parent().addClass('is-checked');
  },

  filterBySearch: _.debounce(function() {
        var qsRegex = new RegExp( this.$('#quicksearch').val(), 'gi' );
        this.$('.isotope').isotope({
          filter: function() {
          return qsRegex ? $(this).text().match( qsRegex ) : true;
          }
         });
    }, 200
    ),

  listView: function(e) {
    var $target = $(e.target);    
    this.$('.isotope')
    .addClass('list').removeClass('tile')
    .isotope({
    layoutMode: 'vertical'
    });
    this.toggleButtonClass($target);
    this.toggleParentButtonClass($target);
  },

  tileView: function(e) {
    var $target = $(e.target);
    this.$('.isotope')
    .addClass('tile').removeClass('list')
    .isotope({
    layoutMode: 'fitRows'    
    });
    this.toggleButtonClass($target);
    this.toggleParentButtonClass($target);
  },

  print: function(e) {    
    $listButton = $('.list-button');
    this.listView(e);    
    window.print();
    //@TODO- Pull out this toggle code to its own function
    this.toggleButtonClass($listButton);
    this.toggleParentButtonClass($listButton);


  }


});

isotopeInit = new Isotope();

