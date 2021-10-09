controller:
	php spark make:controller $(name)

model:
	php spark make:model $(name)

migration:
	php spark make:migration create_$(name)_table

migrate:
	php spark migrate

serve:
	php spark serve --port 8085