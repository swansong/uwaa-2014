<?php namespace UWAA\View\ThumbnailBrowser\Thumbnail;

use \UWAA\View\ThumbnailBrowser\ThumbnailBrowser;
use \UWAA\View\UI;

class EventsIsotope extends ThumbnailBrowser implements Thumbnail 
{

	protected $args;
    

    private $UI;

    //Properties Used to Build The Thumbnail For the Homepage
    protected $postTitle;
    protected $postURL;
    protected $postCalloutText;
    protected $postDate;
    protected $postSubtitle;
    protected $postImageThumbnailURL;
    protected $postExcerpt;    

    public function __construct()
    {
        $this->args = $this->setArguments();
        

        $this->UI = new UI;

    }

      public function extractPostInformation($query) 
  {

        while ( $query->have_posts() ) : $query->the_post();


        $this->postTitle = strip_tags(get_the_title(get_the_ID()));
        $this->postURL = get_permalink();
        $this->postCalloutText = strip_tags(get_post_meta(get_the_ID(), 'mb_thumbnail_callout', true));
        $this->postImageThumbnailURL = $this->UI->returnPostFeaturedImageURL(get_post_thumbnail_id(get_the_ID()), 'isotopeGrid');        
        $this->postDate = strip_tags(get_post_meta(get_the_ID(), 'mb_cosmetic_date', true));;
        $this->postSubtitle = parent::getPostSubtitle($query);
        $this->postExcerpt = esc_html($this->shortenExcerpt(get_the_excerpt(), 180));
        $this->postTerms = strtolower(implode( " ", $this->getListOfTerms()));
        
        echo $this->buildTemplate();

    endwhile;

    wp_reset_postdata();    

  }

  private function getListOfTerms()
    {

        $terms = get_the_terms(get_the_id(), 'events');
        $termArray = array(); 
        
        if ( $terms && !is_wp_error( $terms ) ) :
        	foreach ( $terms as $term ) {
                $termArray[] = $term->slug;
                }               
        endif;

     	return $termArray;
     }

  private function setArguments()
  {
    $args = array (
      'post_type' => 'events',
      'orderby' => 'meta_value',      
      'order' => 'ASC',
      'meta_key' => 'mb_start_date',
      'meta_query' => array(
        'key' => 'mb_start_date',
        'type' => 'DATE',
        'value' => date("Y-m-d"), // Set today's date (note the similar format)
        'compare' => '>=', // Return the ones greater than today's date
      ),      
      'posts_per_page' => -1,

      );

    return $args;
  }

   protected function renderImage() {
    if ($this->postImageThumbnailURL) {
      return '<img src="' . $this->postImageThumbnailURL . '"/>';
    } 
    return '<img src="http://fpoimg.com/275x190?text=FPO" />';

   }  


	public function buildTemplate(){
  $callout = $this->renderCallout();
  $image = $this->renderImage();
  // $dateDebug = $this->args['meta_query']['value'];
	$template = <<<ISOTOPE
<div class="post-thumbnail-slide $this->postTerms">
	<a href="$this->postURL" title="$this->postTitle">
    <div class="image-frame">
      $callout
		  $image
    </div>
		<div class="copy">
		<h6 class="subtitle">$this->postSubtitle</h6>
		<h4 class="title">$this->postTitle</h4>
		<h4 class="date">$this->postDate</h4>
		<p>$this->postExcerpt</p>
		</div>
	</a>
  
</div>

ISOTOPE;
return $template;
}


}