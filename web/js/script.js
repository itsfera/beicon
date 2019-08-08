// Change Article Progress Bar function ////////////////////////////////////////////////////////////////////////////////
function articleProgress(percent) {
	$('.article-progress').each(function () {
		$(this).css('background', 'linear-gradient(to right, #B3A170 ' + percent + '%, rgba(234, 203, 198, 0.3) 0%)');
	})
}

// add to favorites
function addFav() {
	if (window.sidebar && window.sidebar.addPanel) { // Mozilla Firefox Bookmark
		window.sidebar.addPanel(document.title, window.location.href, '');
	} else if (window.external && ('AddFavorite' in window.external)) { // IE Favorite
		window.external.AddFavorite(location.href, document.title);
	} else if (window.opera && window.print) { // Opera Hotlist
		this.title = document.title;
		return true;
	} else { // webkit - safari/chrome
		alert('Нажмите ' + (navigator.userAgent.toLowerCase().indexOf('mac') != -1 ? 'Command/Cmd' : 'CTRL') + ' + D для добавления страницы в закладки');
	}
}

// Функция для разбора урла
function getUrlGetVars() {
	var vars = [], hash;
	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	for (var i = 0; i < hashes.length; i++) {
		hash = hashes[i].split('=');
		vars.push(hash[0]);
		vars[hash[0]] = hash[1];
	}
	return vars;
}


window.onpopstate = function (event) {
	window.location.reload();
};

// Init sliders functions //////////////////////////////////////////////////////////////////////////////////////////////
function initSimpleSlider(selector, space, space1279, space1023, space767, space480, freeMode = true) {
	$(selector).each(function () {
		var simpleSlider = new Swiper(this, {
			freeMode: freeMode,
			centeredSlides: false,
			slidesPerView: 'auto',
			spaceBetween: space,
			navigation: {
				nextEl: $(this).find('.swiper-button-next'),
				prevEl: $(this).find('.swiper-button-prev'),
			},
			breakpoints: {
				1279: {
					spaceBetween: space1279,
				},
				1023: {
					spaceBetween: space1023,
				},
				// when window width is <= 767px
				767: {
					spaceBetween: space767,
				},
				480: {
					spaceBetween: space480,
				}
			}
		});
	});
}

function initRichSlider(space) {
	$('.rich-slider').each(function () {
		var richSlider = new Swiper(this, {
			freeMode: false,
			centeredSlides: false,
			slidesPerView: 1,
			spaceBetween: space,
			navigation: {
				nextEl: $(this).find('.swiper-button-next'),
				prevEl: $(this).find('.swiper-button-prev'),
			},
			pagination: {
				el: '.swiper-pagination',
				type: 'bullets',
				clickable: true,
			},
			observer: true,
			breakpoints: {
				// when window width is <= 767px
				767: {
					slidesPerView: 'auto',
					spaceBetween: 12,
					freeMode: true,
				}
			}
		});

		// Slides Counter
		var totalSlides = richSlider.slides.length,
			currentSlide = richSlider.activeIndex + 1;
		$('.swiper-container').find('.swiper-slide__total').text(totalSlides);
		$('.swiper-container').find('.swiper-slide__current').text(currentSlide);

		// Change Current slide index on change slide
		richSlider.on('slideChange', function () {
			var currentSlide = richSlider.activeIndex + 1;
			$('.swiper-container').find('.swiper-slide__current').text(currentSlide);
		});
	});
}


// Set data-item-id function ///////////////////////////////////////////////////////////////////////////////////////////
function setDataItemId(gallerySelector, itemsSelector) {
	$(gallerySelector).each(function () {
		var itemsArr = $(this).find(itemsSelector);

		for (var i = 0; i < itemsArr.length; i++) {
			itemsArr.eq(i).attr('data-item-id', i);
		}
	});
}


// Init Galleries With Fullscreen Function
function initGalleryFullscreen(gallerySelector, previews, previewItem, fullscreen) {
	$(gallerySelector).each(function () {

		var galleryPrev = $(this).find(previews),
			galleryFulls = $(this).find('.gallery-fullscreen__swiper'),
			swiperEl = $(this);

		// Set Data ID
		setDataItemId(gallerySelector, previewItem);
		var galleryPrevItems = $(this).find(previewItem);

		galleryPrevItems.click(function () {
			var currentSlide = $(this).attr('data-item-id');
			var currentGallery = $(this).attr('data-gallery');
			$('.overlay-bg_dark').fadeIn().css('z-index', '115');
			$('body').addClass('stop-scroll');


			var get = getUrlGetVars();
			if (!get["gallery"]) {
				window.history.pushState('?gallery=' + currentGallery + '&item=' + currentSlide, 'gallery=' + currentGallery + '&item=' + currentSlide, '?gallery=' + currentGallery + '&item=' + currentSlide);
			}

			swiperEl.find(fullscreen).fadeIn();
			var galleryFullscreen = new Swiper(galleryFulls, {
				on: {
					init: function () {
						var mySwiper = $(this)[0],
							fullscreen = $(mySwiper.$wrapperEl[0].parentNode).closest('.gallery-fullscreen'),
							swiperContainer = fullscreen.find('.swiper-container');
						if (swiperContainer.has('.swiper-slide-count')) {
							fullscreen.find('.swiper-slide__current').text(mySwiper.activeIndex + 1);
							fullscreen.find('.swiper-slide__total').text(mySwiper.slides.length);
						}
//                         console.log(mySwiper.imagesToLoad[mySwiper.activeIndex].baseURI);
						let url = encodeURIComponent(mySwiper.imagesToLoad[mySwiper.activeIndex + 1].baseURI);
						let title = mySwiper.imagesToLoad[mySwiper.activeIndex + 1].alt;

//                         console.log('init');
						$('.vkGalleryShare').attr('href', 'https://vk.com/share.php?url=' + url + '&title=' + title + '&utm_source=share2');
						$('.facebookGalleryShare').attr('href', 'https://www.facebook.com/sharer.php?src=sp&u=' + url + '&title=' + title + '&utm_source=share2');
						$('.twitterGalleryShare').attr('href', 'https://twitter.com/intent/tweet?url=' + url + '&text=' + title + '&utm_source=share2');
						$('.okGalleryShare').attr('href', 'https://connect.ok.ru/offer?url=' + url + '&title=' + title + '&utm_source=share2');

					},
					slideChange: function () {

						var mySwiper = $(this)[0],
							fullscreen = $(mySwiper.$wrapperEl[0].parentNode).closest('.gallery-fullscreen'),
							swiperContainer = fullscreen.find('.swiper-container');
						if (swiperContainer.has('.swiper-slide-count')) {
							fullscreen.find('.swiper-slide__current').text(mySwiper.activeIndex + 1);
						}

						var get = getUrlGetVars();

						if (parseInt(get["item"]) != mySwiper.activeIndex) {
							window.history.pushState('?gallery=' + currentGallery + '&item=' + mySwiper.activeIndex, 'gallery=' + currentGallery + '&item=' + mySwiper.activeIndex, '?gallery=' + currentGallery + '&item=' + mySwiper.activeIndex);


							let url = encodeURIComponent(window.location);
							let title = mySwiper.imagesToLoad[mySwiper.activeIndex].alt;

							$('.vkGalleryShare').attr('href', 'https://vk.com/share.php?url=' + url + '&title=' + title + '&utm_source=share2');
							$('.facebookGalleryShare').attr('href', 'https://www.facebook.com/sharer.php?src=sp&u=' + url + '&title=' + title + '&utm_source=share2');
							$('.twitterGalleryShare').attr('href', 'https://twitter.com/intent/tweet?url=' + url + '&text=' + title + '&utm_source=share2');
							$('.okGalleryShare').attr('href', 'https://connect.ok.ru/offer?url=' + url + '&title=' + title + '&utm_source=share2');

						}

					}
				},
				slidesPerView: 1,
				initialSlide: currentSlide,
				spaceBetween: 24,
				navigation: {
					nextEl: galleryFulls.find('.swiper-button-next'),
					prevEl: galleryFulls.find('.swiper-button-prev'),
				}
			});
		});

		//Close gallery-tile Popup
		$('.overlay-bg_dark').click(function () {
			$(fullscreen).fadeOut();
			$('body').removeClass('stop-scroll');
			$('.overlay-bg_dark').fadeOut(500, function () {
				$(this).css('z-index', '');
			});
		});
		$('.close-btn').click(function () {
			$(fullscreen).fadeOut();
			$('body').removeClass('stop-scroll');
			$('.overlay-bg_dark').fadeOut(500, function () {
				$(this).css('z-index', '');
			});
		})
	});
}


// Init Gallery Mosaic Function ////////////////////////////////////////////////////////////////////////////////////////
function initGalleryMosaic() {
	// Set Data ID on the preview images
	setDataItemId('.gallery-mosaic', '.gallery-mosaic__item');

	$('.gallery-mosaic').each(function () {

		var galleryMosaic = $(this).find('.gallery-mosaic__list'),
			galleryMosaicItems = $(this).find('.gallery-mosaic__item'),
			galleryFullscreen = $(this).find('.gallery-fullscreen__swiper'),
			galleryPopup = $(this).find('.gallery-fullscreen'),
			overlay = $('.overlay-bg_dark'),
			body = $('body');

		// Init Gallery Mosaic

		var $mosaic = galleryMosaic.masonry({
			itemSelector: '.gallery-mosaic__item',
			columnWidth: '.gallery-mosaic__col-width',
			gutter: '.gallery-mosaic__space-items',
			fitWidth: false,
		});

		// Render Layout Mosaic after each image loads
		$mosaic.imagesLoaded().progress(function () {
			$mosaic.masonry('layout');
		});

		// Open Gallery Fullscreen on click on image
		galleryMosaicItems.click(function (e) {
			e.preventDefault();
			var currentSlide = $(this).attr('data-item-id');
			var currentGallery = $(this).attr('data-gallery');
			overlay.fadeIn().css('z-index', '115');
			body.addClass('stop-scroll');
			galleryPopup.fadeIn(500);

			var get = getUrlGetVars();
			console.log(get);
			if (!get["gallery"]) {
				window.history.pushState('?gallery=' + currentGallery + '&item=' + currentSlide, "Title", '?gallery=' + currentGallery + '&item=' + currentSlide);
			}
			var galleryFull = new Swiper(galleryFullscreen, {
				slidesPerView: 1,
				initialSlide: currentSlide,
				spaceBetween: 0,
				navigation: {
					nextEl: galleryPopup.find('.swiper-button-next'),
					prevEl: galleryPopup.find('.swiper-button-prev'),
				},
				on: {
					// slideChange: function () {
					//     var mySwiper = $(this)[0];
					//     window.history.pushState('?gallery='+currentGallery+'&item='+mySwiper.activeIndex, "Title", '?gallery='+currentGallery+'&item='+mySwiper.activeIndex);
					//
					// },
					init: function () {
						var mySwiper = $(this)[0],
							fullscreen = $(mySwiper.$wrapperEl[0].parentNode).closest('.gallery-fullscreen'),
							swiperContainer = fullscreen.find('.swiper-container');
						if (swiperContainer.has('.swiper-slide-count')) {
							fullscreen.find('.swiper-slide__current').text(mySwiper.activeIndex + 1);
							fullscreen.find('.swiper-slide__total').text(mySwiper.slides.length);
						}

						let url = encodeURIComponent(mySwiper.imagesToLoad[mySwiper.activeIndex + 1].baseURI);
						let title = mySwiper.imagesToLoad[mySwiper.activeIndex + 1].alt;


						$('.vkGalleryShare').attr('href', 'https://vk.com/share.php?url=' + url + '&title=' + title + '&utm_source=share2');
						$('.facebookGalleryShare').attr('href', 'https://www.facebook.com/sharer.php?src=sp&u=' + url + '&title=' + title + '&utm_source=share2');
						$('.twitterGalleryShare').attr('href', 'https://twitter.com/intent/tweet?url=' + url + '&text=' + title + '&utm_source=share2');
						$('.okGalleryShare').attr('href', 'https://connect.ok.ru/offer?url=' + url + '&title=' + title + '&utm_source=share2');

					},
					slideChange: function () {
						var mySwiper = $(this)[0],
							fullscreen = $(mySwiper.$wrapperEl[0].parentNode).closest('.gallery-fullscreen'),
							swiperContainer = fullscreen.find('.swiper-container');
						if (swiperContainer.has('.swiper-slide-count')) {
							fullscreen.find('.swiper-slide__current').text(mySwiper.activeIndex + 1);
						}


						var get = getUrlGetVars();
						if (parseInt(get["item"]) != mySwiper.activeIndex) {

							window.history.pushState('?gallery=' + currentGallery + '&item=' + mySwiper.activeIndex, 'gallery=' + currentGallery + '&item=' + mySwiper.activeIndex, '?gallery=' + currentGallery + '&item=' + mySwiper.activeIndex);

							let url = encodeURIComponent(window.location);
							let title = mySwiper.imagesToLoad[mySwiper.activeIndex].alt;

							$('.vkGalleryShare').attr('href', 'https://vk.com/share.php?url=' + url + '&title=' + title + '&utm_source=share2');
							$('.facebookGalleryShare').attr('href', 'https://www.facebook.com/sharer.php?src=sp&u=' + url + '&title=' + title + '&utm_source=share2');
							$('.twitterGalleryShare').attr('href', 'https://twitter.com/intent/tweet?url=' + url + '&text=' + title + '&utm_source=share2');
							$('.okGalleryShare').attr('href', 'https://connect.ok.ru/offer?url=' + url + '&title=' + title + '&utm_source=share2');


						}

					}
				}
			});
		});

		//Close Fullscreen
		overlay.click(function () {
			galleryPopup.fadeOut();
			body.removeClass('stop-scroll');
			overlay.fadeOut(500, function () {
				$(this).css('z-index', '');
			});
		});
		$(this).find('.close-btn').click(function () {
			galleryPopup.fadeOut();
			body.removeClass('stop-scroll');
			overlay.fadeOut(500, function () {
				$(this).css('z-index', '');
			});
		})
	});
}


$(document).ready(function () {
	//Remove href from logo on Main page
	$('#mainPage').find('.logo-img').parent('a').removeAttr('href');


	var menuBlock = $('#menuBlock'),
		slidePage = $('#slidePage'),
		navBar = $('.nav-bar'),
		navBarIcon = $('.nav-btn-item'),
		popup = $('.popup'),
		overlayBgTr = $('.overlay-bg_transparent'),
		overlayBgDark = $('.overlay-bg_dark'),
		overlayBgInd = $('.overlay-bg_ind'),
		slidePageTab = $('.slide-page-menu__item'),
		slidePageContent = $('.slide-page__body'),
		body = $('body');


	// Close overlay and all left slides (menu, slide page, popups)
	function closeAll() {
		overlayBgTr.css('display', 'none');
		overlayBgDark.fadeOut(300);
		overlayBgInd.fadeOut(300);
		popup.fadeOut(200);
		navBarIcon.removeClass('active');
		menuBlock.removeClass('show');
		slidePage.removeClass('show');
		navBar.removeClass('active');
		body.removeClass('stop-scroll');
	}

	function openSlide() {
		closeAll();
		overlayBgTr.css('display', 'block');
		navBar.addClass('active');
		body.addClass('stop-scroll');
	}

	function changeSlideContent(pageID, tabID, contentID) {
		$(pageID).find(slidePageTab).removeClass('active');
		$(tabID).addClass('active');
		slidePageContent.css('display', 'none');
		$(contentID).fadeIn(200);
	}

	function openSlidePage(iconID, pageID, tabID, contentID) {
		if ($(iconID).hasClass('active')) {
			closeAll();
		} else {
			if (slidePage.hasClass('show')) {
				navBarIcon.removeClass('active');
				$(iconID).addClass('active');
				changeSlideContent(pageID, tabID, contentID);
			} else {
				openSlide();
				$(iconID).addClass('active');
				slidePage.addClass('show');
				changeSlideContent(pageID, tabID, contentID);
			}
		}
	}


	overlayBgTr.click(function () {
		closeAll();
	});

	overlayBgInd.click(function () {
		popup.fadeOut(300);
		navBar.removeClass('active');
		body.removeClass('stop-scroll');
		$(this).fadeOut(300);
		$('#searchIcon').removeClass('active');
	});

	overlayBgDark.click(function () {
		popup.fadeOut(300);
		$(this).fadeOut(300);
		/*$('#searchIcon').removeClass('active');*/
		/* navBar.removeClass('active');*/
	});


	slidePage.find('.close-btn').click(function () {
		closeAll();
	});


	// Click listener Menu Icon
	$('#burgerIcon').click(function () {
		if ($(this).hasClass('active')) {
			closeAll();
		} else {
			openSlide();
			$(this).addClass('active');
			menuBlock.addClass('show');
		}
	});

	// Click listener Shopping Icon and Tab
	$('#shopIcon').click(function () {
		if (!($(this).hasClass('disable'))) {
			openSlidePage('#shopIcon', '#slidePage', '#tab1', '#content1');
		}
	});
	$('#tab1').click(function () {
		openSlidePage('#shopIcon', '#slidePage', '#tab1', '#content1');
	});


	// Click listener Favorites Icon and Tab
	$('#favoriteIcon').click(function () {
		if (!($(this).hasClass('disable'))) {
			openSlidePage('#favoriteIcon', '#slidePage', '#tab2', '#content2');
		}
	});
	$('#tab2').click(function () {
		openSlidePage('#favoriteIcon', '#slidePage', '#tab2', '#content2');
	});


	$('.submenu__list').click('.submenu__item', function (event) {
		$('.submenu__item').removeClass('active');
		$(event.target).addClass('active');
		$('.favorites__content').css('display', 'none');
		if ($(event.target).attr('id') === 'subTab1') {
			$('#favContent1').fadeIn(200);
		} else {
			$('#favContent2').fadeIn(200);
		}
	});


	//Click Listener on Login and Reg Buttons
	$('.to-login').click(function () {
		overlayBgDark.fadeIn(300);
		$('#signPopup').fadeIn(300);
		changeSlideContent('#signPopup', '#signInTab', '#signInContent');
	});

	$('.to-reg').click(function () {
		overlayBgDark.fadeIn(300);
		$('#signPopup').fadeIn(300);
		body.addClass('stop-scroll');
		changeSlideContent('#signPopup', '#signUpTab', '#signUpContent');
	});

	popup.find('.close-btn').click(function () {
		overlayBgDark.fadeOut(300);
		$('#signPopup').fadeOut(300);
		/*body.removeClass('stop-scroll');*/
	});

	//Click Listener on Search button
	$('#searchIcon').click(function () {
		if ($(this).hasClass('active')) {
			closeAll();
		} else {
			closeAll();
			overlayBgInd.fadeIn(300);
			navBar.addClass('active');
			$('#searchPopup').fadeIn(300);
			$(this).addClass('active');
			body.addClass('stop-scroll');
		}
	});


	//Scroll and header: collapse and expand
	var lastScrollTop = 0, isReseted = false;

	function slimNav() {
		if ($(window).width() < 768) {
			var scrollTop = $(this).scrollTop(),
				nav = $('.nav-bar'),
				logo = nav.find('.logo-img'),
				NAV_HEIGHT = 88;

			if (scrollTop > lastScrollTop) {
				//scroll down
				if (scrollTop < 60) {
					nav.css('height', NAV_HEIGHT - scrollTop);
					logo.css('transform', 'scale(' + (1 - scrollTop / 150) + ')')
				} else {
					nav.css('height', '20px');
					logo.css('transform', 'scale(0.6)')
				}

			} else if (scrollTop < lastScrollTop && scrollTop < 60) {
				//scroll up
				nav.css('height', NAV_HEIGHT - scrollTop);
				logo.css('transform', 'scale(' + (1 - scrollTop / 200) + ')');
			}
			lastScrollTop = scrollTop;
			isReseted = false;
		} else {
			if (!isReseted) {
				$('.nav-bar').css('height', '').find('.logo-img').css('transform', 'scale(1)');
				/* $('.nav-bar').find('.logo-img').css('transform', 'scale(1)');*/
				isReseted = true;
			}
		}


	}

	$(window).scroll(function () {
		slimNav();
	});

	$(window).resize(function () {
		slimNav();
	});

});