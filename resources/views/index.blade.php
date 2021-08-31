@extends('layout')

@section('content')
<h1>Заявка на кредит</h1>
<form class="calc-form" v-on:submit.prevent="onDemand">
	<div class="row g-3 mb-4">
		<div class="col-md-6 col-lg-4">
			<label for="inp_p_ln" class="form-label">Фамилия</label>
			<input type="text" class="form-control" id="inp_p_ln" v-model="form.name" required>
		</div>
		<div class="col-md-6 col-lg-4">
			<label for="inp_p_n" class="form-label">Имя</label>
			<input type="text" class="form-control" id="inp_p_n" v-model="form.last_name" required>
		</div>
		<div class="col-md-6 col-lg-4">
			<label for="inp_p_sn" class="form-label">Отчество</label>
			<input type="text" class="form-control" id="inp_p_sn" v-model="form.second_name">
		</div>
	</div>
	<div class="row g-3 mb-4">
		<div class="col-md-6">
			<label for="inp_p_g" class="form-label">Пол</label>
			<select id="inp_p_g" class="form-select" v-model="form.gender">
				<option value="" selected>Выберите</option>
				<option value="0">Женщина</option>
				<option value="1">Мужчина</option>
			</select>
		</div>
		<div class="col-md-6">
			<label for="inp_p_b" class="form-label">Дата рождения</label>
			<input type="date" class="form-control" id="inp_p_b" v-model="form.birthday" required>
		</div>
	</div>
	<div class="row g-3 mb-4">
		<div class="col-md-6">
			<label for="inp_f_e" class="form-label">Семейное положение</label>
			<select id="inp_f_e" class="form-select" v-model="form.engagement" required>
				<option value="" selected>Выберите</option>
				<option value="0">холост/не замужем</option>
				<option value="1">женат/замужем</option>
			</select>
		</div>
		<div class="col-md-6">
			<label for="inp_f_i" class="form-label">Количество несовершеннолетних детей</label>
			<input type="number" class="form-control" id="inp_f_i" placeholder="От 0 до 30" min="0" max="30" v-model="form.infants" required>
		</div>
	</div>
	<div class="row g-3 mb-4">
		<div class="col-md-6">
			<label for="inp_w_s" class="form-label">Ежемесячный доход</label>
			<input type="number" class="form-control" id="inp_w_s" placeholder="Прим: 100000" min="0" v-model="form.salary" required>
		</div>
		<div class="col-md-6">
			<label for="inp_w_t" class="form-label">Тип занятости</label>
			<select id="inp_w_t" class="form-select" v-model="form.employment" required>
				<option value="" selected>Выберите</option>
				<option value="0">Не работаю</option>
				<option value="1">Договор</option>
				<option value="2">Самозанятый</option>
				<option value="3">Индивидуальный предприниматель</option>
			</select>
		</div>
		<div class="col-md-6">
			<label for="inp_i_p" class="form-label">Есть ли недвижимость</label>
			<select id="inp_i_p" class="form-select" v-model="form.has_property" required>
				<option value="" selected>Выберите</option>
				<option value="0">Нет</option>
				<option value="1">Да</option>
			</select>
		</div>
		<div class="col-md-6">
			<label for="inp_c_o" class="form-label">Есть ли непогашенные кредиты</label>
			<select id="inp_c_o" class="form-select" v-model="form.has_credits" required>
				<option value="" selected>Выберите</option>
				<option value="0">Нет</option>
				<option value="1">Да</option>
			</select>
		</div>
		<div class="col-md-6">
			<label for="inp_c_i" class="form-label">Есть ли задолженности по текущим кредитам</label>
			<select id="inp_c_i" class="form-select" v-model="form.has_debt" :disabled="related_disabled">
				<option value="" selected>Выберите</option>
				<option value="0">Нет</option>
				<option value="1">Да</option>
			</select>
		</div>
		<div class="col-md-6">
			<label for="inp_c_s" class="form-label">Ежемесячная выплата по текущим кредитам</label>
			<input type="text" class="form-control" id="inp_c_s" placeholder="Прим: 50000" v-model="form.current_debt" :disabled="related_disabled">
		</div>
	</div>
	<div class="row g-3 mb-4">
		<div class="col-12">
			<button type="submit" class="btn btn-primary">Отправить</button>
		</div>
	</div>
</form>

<div class="modal fade show" id="msgModal" tabindex="-1" aria-labelledby="msgModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="msgModalLabel">Результат запроса</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				@{{ errormsg }}
			</div>
		</div>
	</div>
</div>
@stop
