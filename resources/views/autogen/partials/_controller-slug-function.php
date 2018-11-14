
		$input['slug'] = General::slug(${$SINGULAR_NAME}->{$NAME_COLUMN},${$SINGULAR_NAME}->id);
		${$SINGULAR_NAME}->update($input);
