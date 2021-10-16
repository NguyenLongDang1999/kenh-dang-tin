controller:
	php spark make:controller $(name)

model:
	php spark make:model $(name)

migration:
	php spark make:migration create_$(name)_table

refresh:
	php spark migrate:refresh

migrate:
	php spark migrate && php spark migrate -all

seeder:
	php spark make:seeder $(name)

dbseed:
	php spark db:seed $(name)

serve:
	php spark serve --port 8085