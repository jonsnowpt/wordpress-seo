<?php

namespace Yoast\WP\SEO\Tests\Presenters\Twitter;

use Brain\Monkey;
use Mockery;
use Yoast\WP\SEO\Presentations\Indexable_Presentation;
use Yoast\WP\SEO\Presenters\Twitter\Title_Presenter;
use Yoast\WP\SEO\Tests\TestCase;

/**
 * Class Title_Presenter_Test
 *
 * @coversDefaultClass \Yoast\WP\SEO\Presenters\Twitter\Title_Presenter
 *
 * @group presenters
 * @group twitter-title
 */
class Title_Presenter_Test extends TestCase {

	/**
	 * The indexable presentation.
	 *
	 * @var Indexable_Presentation
	 */
	protected $indexable_presentation;

	/**
	 * The title presenter instance.
	 *
	 * @var Title_Presenter
	 */
	protected $instance;

	/**
	 * The WPSEO Replace Vars object.
	 *
	 * @var \WPSEO_Replace_Vars|Mockery\MockInterface
	 */
	protected $replace_vars;

	/**
	 * Sets up the test class.
	 */
	public function setUp() {
		$this->instance               = new Title_Presenter();
		$this->instance->presentation = new Indexable_Presentation();
		$this->indexable_presentation = $this->instance->presentation;
		$this->replace_vars           = Mockery::mock( \WPSEO_Replace_Vars::class );

		$this->instance->replace_vars         = $this->replace_vars;
		$this->indexable_presentation->source = [];

		return parent::setUp();
	}

	/**
	 * Tests whether the presenter returns the correct Twitter title.
	 *
	 * @covers ::present
	 */
	public function test_present() {
		$this->indexable_presentation->twitter_title = 'twitter_example_title';

		$this->replace_vars
			->expects( 'replace' )
			->andReturnUsing( function( $str ) {
				return $str;
			} );

		$expected = '<meta name="twitter:title" content="twitter_example_title" />';
		$actual   = $this->instance->present();
		$this->assertEquals( $expected, $actual );
	}

	/**
	 * Tests whether the presenter returns an empty string when the Twitter title is empty.
	 *
	 * @covers ::present
	 */
	public function test_present_twitter_title_is_empty() {
		$this->indexable_presentation->twitter_title = '';

		$this->replace_vars
			->expects( 'replace' )
			->andReturnUsing( function( $str ) {
				return $str;
			} );

		$actual = $this->instance->present();
		$this->assertEmpty( $actual );
	}

	/**
	 * Tests whether the presenter returns the correct Twitter title, when the `wpseo_twitter_title` filter is applied.
	 *
	 * @covers ::present
	 * @covers ::get
	 */
	public function test_present_filter() {
		$this->indexable_presentation->twitter_title = 'twitter_example_title';

		$this->replace_vars
			->expects( 'replace' )
			->andReturnUsing( function( $str ) {
				return $str;
			} );

		Monkey\Filters\expectApplied( 'wpseo_twitter_title' )
			->once()
			->with( 'twitter_example_title', $this->indexable_presentation )
			->andReturn( 'twitterexampletitle' );

		$expected = '<meta name="twitter:title" content="twitterexampletitle" />';
		$actual   = $this->instance->present();

		$this->assertEquals( $expected, $actual );
	}
}
