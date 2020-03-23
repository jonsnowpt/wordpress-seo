import initTabs from "./initializers/metabox-tabs";
import initPrimaryCategory from "./initializers/primary-category";
import initPostScraper from "./initializers/post-scraper";
import initFeaturedImageIntegration from "./initializers/featured-image";

initTabs( jQuery );

if ( typeof wpseoPrimaryCategoryL10n !== "undefined" ){
	initPrimaryCategory( jQuery );
}

initPostScraper( jQuery );

if ( typeof wpseoFeaturedImageL10n !=="undefined" ){
	initFeaturedImageIntegration( jQuery );
}