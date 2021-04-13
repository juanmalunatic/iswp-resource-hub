(function( $ ) {
	'use strict';

	$(function(){
		// Avoid loading the code more than once.
		if (window.reshubWasLoaded === 1) {
			return null;
		} else {
			window.reshubWasLoaded = 1;
			reshubSetup();
		}
	});

	function reshubSetup(){

		// Abort if no data
		const resHubs = window.reshub_json;
		if (resHubs === undefined) {
			console.error("No resHub data was found.");
			return false;
		}

		// Window.reshub_json may contain several keys, according
		// to how many Hubs exist in the page.
		window.flags = [];
		for (const key in resHubs) {
			renderReshub(key, window.reshub_json[key]);
			window.flags[key] = [];
		}
	}

	function renderReshub(id, resources) {
		// Search whether the id is found, else return
		const reshub_root = document.getElementById('reshub_' + id);
		if (reshub_root === null) {
			console.error(`Data for ${key} was found but the element with id 'reshub_${key}' isn't present in the page.`);
			return false;
		}

		// Render the select boxes
		initializeYears(reshub_root, resources);

		// Render the searchbar
		initializeSearchbox(reshub_root, resources);

		// Trigger the initial draw
		redrawCards(reshub_root, resources);
	}

	// YEARS

	function initializeYears(rootElem, resources) {

		// Get valid years
		let years = ['All years'];
		years = years.concat(extractYears(resources));

		// Create options in DOM
		let selector = rootElem.querySelector('.reshub_selector_year');
		for (const year of years) {
			let option = document.createElement('option');
			option.value = year;
			option.text = year;
			selector.add(option);
		}

		// Add listener on switch
		selector.addEventListener('change', (event)=>{
			redrawCards(rootElem, resources);
		});

	}

	function extractYears(resources) {
		let arrayVals = [
			... new Set(
				resources
					.filter(item => item.year !== false) // remove items w/o years
					.map( item => item.year) // grab year value
			)
		];
		arrayVals.sort(compareNumbers);
		return arrayVals;
	}

	function compareNumbers(a, b) {
		return a - b;
	}

	// SEARCH

	function initializeSearchbox(rootElem, resources) {

		let searchbox = rootElem.querySelector('.reshub_searchbar');
		let key = rootElem.id.replace('reshub_', '');

		// Clear the box on the first click
		searchbox.addEventListener('click', (event) => {
			if (
				window.flags[key]['search_focused'] === undefined ||
				window.flags[key]['search_focused'] === 0
			) {
				searchbox.value = '';
				window.flags[key]['search_focused'] = 1;
			}
		});

		// Re-populate the box if leaving while empty
		searchbox.addEventListener('blur', (event) => {
			if (searchbox.value === '' && window.flags[key]['search_focused'] === 1) {
				searchbox.value = 'Filter by Keywords or Title';
				window.flags[key]['search_focused'] = 0;
			}
		});

		// This does the actual filtering
		searchbox.addEventListener('input', (event) => {
			redrawCards(rootElem, resources);
		});

	}

	function redrawCards(rootElem, resources) {
		// Get data
		const filtered_resources = filterResources(rootElem, resources);
		const card_holder = rootElem.querySelector('.reshub_cards');

		// Destroy stage
		card_holder.innerHTML = '';

		// Recreate stage
		for (const resource of filtered_resources) {
			let new_resource = createResourceCard(resource);
			card_holder.appendChild(new_resource);
		}
	}

	function filterResources(rootElem, resources) {
		let sel_year = rootElem.querySelector('.reshub_selector_year');
		let sch_wrds = rootElem.querySelector('.reshub_searchbar');

		const filter_year = sel_year.value;
		const filter_wrds = sch_wrds.value;

		let resources_filtered = resources;

		// First, filter by year
		if (filter_year !== 'All years') {
			resources_filtered = resources_filtered.filter(
				item => item.year === filter_year
			);
		}

		// Then, filter by title OR keyword
		if ((filter_wrds !== "") && (filter_wrds !== 'Filter by Keywords or Title')) {
			resources_filtered = resources_filtered.filter(
				(item) => {
					// Create an intermediate field to search
					let searched_text  = (item.title + " " + item.keywords).toLowerCase();
					let filter_words = filter_wrds.toLowerCase();
					return searched_text.includes(filter_words);
				}
			)
		}

		return resources_filtered;
	}

	function createResourceCard(resource_data) {
		const renderedCard = renderCard(resource_data);

		let new_div = document.createElement('div');
		new_div.className = 'reshub_card_holder';
		new_div.innerHTML = renderedCard;

		return new_div;
	}

	function renderCard(res_data) {

		const title       = res_data['title'];
		const description = res_data['description'] ? res_data['description'] : '';
		const link        = res_data['link'];
		const image_url   = res_data['image'];
		const year        = res_data['year'];
		const keywords    = res_data['keywords'];

		const template = `
		<div class="reshub_card">
			<a class="reshub_card_link" href="${link}">
				<div class="reshub_card_image"
					 style="background-image: url(${image_url}) ">	
				</div>
				<div class="reshub_card_texts">
					<div class="reshub_card_year">
						<strong>
							Year:
						</strong>
						${year}					
					</div>
					<div class="reshub_card_keywords">
						<strong>
							Keywords: 						
						</strong>
						${keywords}
					</div>
					<div class="reshub_card_title">
						${title}
					</div>
					<div class="reshub_card_description">
						${description}
					</div>
				</div>		
			</a>
		</div>
		`;

		return template;


	}

})(jQuery);
