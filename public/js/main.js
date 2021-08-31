"use strict";

document.addEventListener("DOMContentLoaded", function() {
	const route = '/calc';


	let app = new Vue({
		el: '#app',
		data: {
			form: {
				name: 'Константин',
				last_name: 'Константинопольский',
				second_name: '',
				gender: '1',
				birthday: '1987-01-01',
				infants: 1,
				engagement: '0',
				salary: 32000,
				employment: '1',
				has_property: '0',
				has_credits: '0',
				has_debt: '',
				current_debt: null,
			},
			related_disabled: true,
			errormsg: '',
			bsModal: null
		},
		beforeMount() {
		},
		mounted() {
			this.bsModal = new bootstrap.Modal(document.getElementById('msgModal'));
		},
		watch: {
			'form.has_credits': function(val, oldVal) {
				this.related_disabled = (val != 1);
				console.log(this.related_disabled);
			}
		},
		methods: {
			onDemand() {
				const defaultErrorMessage = 'Возникла ошибка, попробуйте перезагрузить страницу и попробовать снова.';
				const msgSuccess = 'Одобрение в выдаче кредита';
				const msgFail = 'Отказ в выдаче кредита';

				this.errormsg = '';

				axios
					.post(route, this.form)
					.then(response => {
						console.info('risk_weight: ' + response.data.weight);
						if (!_.isEmpty(response.data.errors)) {
							this.errormsg = defaultErrorMessage;
						} else {
							if (response.data.status == 'success') {
								this.errormsg = msgSuccess;
							} else {
								this.errormsg = msgFail;
							}
						}
						this.bsModal.show();
					});
			},
		}
	});
});