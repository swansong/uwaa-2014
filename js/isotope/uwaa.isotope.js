var Tour=Backbone.Model.extend({}),Tours=Backbone.Collection.extend({model:Tour,url:"http://dev.alumni.washington.edu/wordpress/cms-test/feed/?post_type=tours",fetch:function(a){return a=a||{},a.dataType="xml",a.success=console.log("Received"),Backbone.Collection.prototype.fetch.call(this,a)}}),tours=new Tours;tours.fetch(),console.log("hi"),ToursView=Backbone.View.extend({className:"isotope",isotopeContainer:".isotope",filterContainer:"#filter",events:{"click #filters":"filter"},initialize:function(){_.bindAll(this,"render")},filter:function(){},isotope:function(){this.isotopeContainer.isotope({itemSelector:".tour-thumbnail",layoutMode:"fitRows"})},render:function(){return console.log(this.collection.toJSON()),this}}),toursView=new ToursView({collection:tours}),tours.fetch;