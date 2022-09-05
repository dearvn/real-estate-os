jQuery( document ).ready(
	function ($) {
		// Ajax Url
		const ajax_url = wprs_plugin.ajax;

		$( document ).on(
			'change',
			'#cat',
			function (e) {
				e.preventDefault();

				$.ajax(
					{
						url: ajax_url,
						type: 'GET',
						dataType: "json",
						contentType: "application/json; charset=utf-8",
						cache: false,
						data: {
							'action': 'change_category_action' ,
							'nonce': wprs_plugin.nonce,
							'cat': e.target.value,
							'filter': 0
						},
						success: function (data, textStatus, xhr) {
							$( "#filter-price" ).html( data.data.prices );

						},
						error: function (xhr, status, error) {
							$( "#filter-price" ).html( '<option value="">All Prices</option>' );
						}
					}
				);
			}
		);

		$( document ).on(
			'change',
			'.location-city',
			function (e) {
				e.preventDefault();

				$.ajax(
					{
						url: ajax_url,
						type: 'GET',
						dataType: "json",
						contentType: "application/json; charset=utf-8",
						cache: false,
						data: {
							'action': 'change_city_action' ,
							'nonce': wprs_plugin.nonce,
							'city': e.target.value,
							'filter': e.target.id == 'filter-city' ? 1 : 0
						},
						success: function (data, textStatus, xhr) {
							if (e.target.id == 'filter-city') {
								$( "#filter-district" ).html( data.data.dists );
								$( "#filter-ward" ).html( '<option value="">All Wards</option>' );
								$( "#filter-street" ).html( '<option value="">All Streets</option>' );
								$( "#filter-project" ).html( '<option value="">All Projects</option>' );
							} else {
								$( "#dr-district" ).html( data.data.dists );
								$( "#dr-ward" ).html( '<option value="">Select One</option>' );
								$( "#dr-street" ).html( '<option value="">Select One</option>' );
								$( "#dr-project" ).html( '<option value="">Select One</option>' );
							}
						},
						error: function (xhr, status, error) {
							if (e.target.id == 'filter-city') {
								$( "#filter-district" ).html( '<option value="">All Districts</option>' );
								$( "#filter-ward" ).html( '<option value="">All Wards</option>' );
								$( "#filter-street" ).html( '<option value="">All Streets</option>' );
								$( "#filter-project" ).html( '<option value="">All Projects</option>' );
							} else {
								$( "#dr-district" ).html( '<option value="">Select One</option>' );
								$( "#dr-ward" ).html( '<option value="">Select One</option>' );
								$( "#dr-street" ).html( '<option value="">Select One</option>' );
								$( "#dr-project" ).html( '<option value="">Select One</option>' );
							}

						}
					}
				);
			}
		);

		$( document ).on(
			'change',
			'.location-district',
			function (e) {
				e.preventDefault();

				$.ajax(
					{
						url: ajax_url,
						type: 'GET',
						dataType: "json",
						contentType: "application/json; charset=utf-8",
						cache: false,
						data: {
							'action': 'change_district_action' ,
							'nonce': wprs_plugin.nonce,
							'district': e.target.value,
							'filter': e.target.id == 'filter-district' ? 1 : 0
						},
						success: function (data, textStatus, xhr) {
							if (e.target.id == 'filter-district') {
								$( "#filter-ward" ).html( data.data.wards );
								$( "#filter-street" ).html( data.data.streets );
								$( "#filter-project" ).html( data.data.projects );
							} else {
								$( "#dr-ward" ).html( data.data.wards );
								$( "#dr-street" ).html( data.data.streets );
								$( "#dr-project" ).html( data.data.projects );
							}
						},
						error: function (xhr, status, error) {
							if (e.target.id == 'filter-district') {
								$( "#filter-ward" ).html( '<option value="">All Wards</option>' );
								$( "#filter-street" ).html( '<option value="">All Streets</option>' );
								$( "#filter-project" ).html( '<option value="">All Projects</option>' );
							} else {
								$( "#dr-ward" ).html( '<option value="">Select Ward</option>' );
								$( "#dr-street" ).html( '<option value="">Select Street</option>' );
								$( "#dr-project" ).html( '<option value="">Select Project</option>' );
							}

						}
					}
				);
			}
		);

	}
);
