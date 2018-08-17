<?php

return [
    'update' => 'Actualizar',
    'save' => 'Guardar',
    'add' => 'Añadir',
    'cancel' => 'Cancelar',
    'delete' => 'Eliminar',
    'edit' => 'Editar',
    'upload' => 'Subir',
    'close' => 'Cerrar',
    'create' => 'Crear',
    'remove' => 'Remover',
    'revoke' => 'Revoke',
    'done' => 'Done',
    'verify' => 'Verify',
    'for' => 'for',
    'new' => 'new',
    'unknown' => 'I don’t know',
    'load_more' => 'Load more',
    'loading' => 'Loading...',
    'with' => 'with',
    'days' => 'day|days',

    'application_title' => 'Monica – personal relationship manager',
    'application_description' => 'Monica is a tool to manage your interactions with your loved ones, friends and family.',
    'application_og_title' => 'Have better relations with your loved ones. Free Online CRM for friends and family.',

    'markdown_description' => '¿Desea dar formato a su texto de una manera agradable? Soportamos el uso de Markdown para añadir negrita, cursiva, listas y más.',
    'markdown_link' => 'Leer documentación',

    'header_settings_link' => 'Configuración',
    'header_logout_link' => 'Salir',
    'header_changelog_link' => 'Product changes',

    'main_nav_cta' => 'Add people',
    'main_nav_dashboard' => 'Dashboard',
    'main_nav_family' => 'Contactos',
    'main_nav_journal' => 'Diario',
    'main_nav_activities' => 'Actividades',
    'main_nav_tasks' => 'Tareas',

    'footer_remarks' => 'Any remarks?',
    'footer_send_email' => 'Enviarme un email',
    'footer_privacy' => 'Políticas de privacidad',
    'footer_release' => 'Notas de la versión',
    'footer_newsletter' => 'Newsletter',
    'footer_source_code' => 'Contribuir',
    'footer_version' => 'Version: :version',
    'footer_new_version' => 'Una nueva versión esta disponible',

    'footer_modal_version_whats_new' => 'Qué hay de nuevo',
    'footer_modal_version_release_away' => 'Estás una versión por detrás de la última disponible. Deberías actualizar tu instancia. | Estás :number versiones por detrás de la última versión disponible. Deberías actualizar tu instancia.',

    'breadcrumb_dashboard' => 'Panel de control',
    'breadcrumb_list_contacts' => 'Lista de personas',
    'breadcrumb_journal' => 'Diario',
    'breadcrumb_settings' => 'Ajustes',
    'breadcrumb_settings_export' => 'Exportar',
    'breadcrumb_settings_users' => 'Usuarios',
    'breadcrumb_settings_users_add' => 'Añadir un usuario',
    'breadcrumb_settings_subscriptions' => 'Suscripción',
    'breadcrumb_settings_import' => 'Importar',
    'breadcrumb_settings_import_report' => 'Importar reporte',
    'breadcrumb_settings_import_upload' => 'Subir',
    'breadcrumb_settings_tags' => 'Etiquetas',
    'breadcrumb_add_significant_other' => 'Añadir relación',
    'breadcrumb_edit_significant_other' => 'Editar relación',
    'breadcrumb_add_note' => 'Añadir una nota',
    'breadcrumb_edit_note' => 'Editar una nota',
    'breadcrumb_api' => 'API',
    'breadcrumb_edit_introductions' => 'How did you meet',
    'breadcrumb_settings_personalization' => 'Personalización',
    'breadcrumb_settings_security' => 'Seguridad',
    'breadcrumb_settings_security_2fa' => 'Two Factor Authentication',
    'breadcrumb_profile' => 'Profile of :name',

    'gender_male' => 'Hombre',
    'gender_female' => 'Mujer',
    'gender_none' => 'Prefiero no decirlo',

    'error_title' => 'Whoops! Something went wrong.',
    'error_unauthorized' => 'You don’t have the right to edit this resource.',
    'error_save' => 'We had an error trying to save the data.',

    'default_save_success' => 'The data has been saved.',

    'compliance_title' => 'Sorry for the interruption.',
    'compliance_desc' => 'We have changed our <a href=":urlterm" hreflang=":hreflang">Terms of Use</a> and <a href=":url" hreflang=":hreflang">Privacy Policy</a>. By law we have to ask you to review them and accept them so you can continue to use your account.',
    'compliance_desc_end' => 'We don’t do anything nasty with your data or account and will never do.',
    'compliance_terms' => 'Accept new terms and privacy policy',

    // Relationship types
    // Yes, each relationship type has 8 strings associated with it.
    // This is because we need to indicate the name of the relationship type,
    // and also the name of the opposite side of this relationship (father/son),
    // and then, the feminine version of the string. Finally, in some sentences
    // in the UI, we need to include the name of the person we add the relationship
    // to.
    'relationship_type_group_love' => 'Relaciones amorosas',
    'relationship_type_group_family' => 'Family relationships',
    'relationship_type_group_friend' => 'Friend relationships',
    'relationship_type_group_work' => 'Work relationships',
    'relationship_type_group_other' => 'Other kind of relationships',

    'relationship_type_partner' => 'significant other',
    'relationship_type_partner_female' => 'significant other',
    'relationship_type_partner_with_name' => ':name’s significant other',
    'relationship_type_partner_female_with_name' => ':name’s significant other',

    'relationship_type_spouse' => 'spouse',
    'relationship_type_spouse_female' => 'spouse',
    'relationship_type_spouse_with_name' => ':name’s spouse',
    'relationship_type_spouse_female_with_name' => ':name’s spouse',

    'relationship_type_date' => 'date',
    'relationship_type_date_female' => 'date',
    'relationship_type_date_with_name' => ':name’s date',
    'relationship_type_date_female_with_name' => ':name’s date',

    'relationship_type_lover' => 'lover',
    'relationship_type_lover_female' => 'lover',
    'relationship_type_lover_with_name' => ':name’s lover',
    'relationship_type_lover_female_with_name' => ':name’s lover',

    'relationship_type_inlovewith' => 'in love with',
    'relationship_type_inlovewith_female' => 'in love with',
    'relationship_type_inlovewith_with_name' => 'someone :name is in love with',
    'relationship_type_inlovewith_female_with_name' => 'someone :name is in love with',

    'relationship_type_lovedby' => 'loved by',
    'relationship_type_lovedby_female' => 'loved by',
    'relationship_type_lovedby_with_name' => ':name’s secret lover',
    'relationship_type_lovedby_female_with_name' => ':name’s secret lover',

    'relationship_type_ex' => 'ex-boyfriend',
    'relationship_type_ex_female' => 'ex-girlfriend',
    'relationship_type_ex_with_name' => ':name’s ex-boyfriend',
    'relationship_type_ex_female_with_name' => ':name’s ex-girlfriend',

    'relationship_type_parent' => 'padre',
    'relationship_type_parent_female' => 'madre',
    'relationship_type_parent_with_name' => 'padre de :name',
    'relationship_type_parent_female_with_name' => 'madre de :name',

    'relationship_type_child' => 'hijo',
    'relationship_type_child_female' => 'hija',
    'relationship_type_child_with_name' => 'hijo de :name',
    'relationship_type_child_female_with_name' => 'hija de :name',

    'relationship_type_sibling' => 'hermano',
    'relationship_type_sibling_female' => 'hermana',
    'relationship_type_sibling_with_name' => 'hermano de :name',
    'relationship_type_sibling_female_with_name' => 'hermana de :name',

    'relationship_type_grandparent' => 'grand parent',
    'relationship_type_grandparent_female' => 'grand parent',
    'relationship_type_grandparent_with_name' => ':name’s grand parent',
    'relationship_type_grandparent_female_with_name' => ':name’s grand parent',

    'relationship_type_grandchild' => 'grand child',
    'relationship_type_grandchild_female' => 'grand child',
    'relationship_type_grandchild_with_name' => ':name’s grand child',
    'relationship_type_grandchild_female_with_name' => ':name’s grand child',

    'relationship_type_uncle' => 'tío',
    'relationship_type_uncle_female' => 'tía',
    'relationship_type_uncle_with_name' => 'tío de :name',
    'relationship_type_uncle_female_with_name' => 'tía de :name',

    'relationship_type_nephew' => 'sobrino',
    'relationship_type_nephew_female' => 'sobrina',
    'relationship_type_nephew_with_name' => 'sobrino de :name',
    'relationship_type_nephew_female_with_name' => 'sobrina de :name',

    'relationship_type_cousin' => 'primo/a',
    'relationship_type_cousin_female' => 'prima',
    'relationship_type_cousin_with_name' => 'primo de :name',
    'relationship_type_cousin_female_with_name' => 'prima de :name',

    'relationship_type_godfather' => 'padrino',
    'relationship_type_godfather_female' => 'madrina',
    'relationship_type_godfather_with_name' => 'padrino de :name',
    'relationship_type_godfather_female_with_name' => 'madrina de :name',

    'relationship_type_godson' => 'ahijado',
    'relationship_type_godson_female' => 'ahijada',
    'relationship_type_godson_with_name' => 'ahijado de :name',
    'relationship_type_godson_female_with_name' => ':name’s goddaughter',

    'relationship_type_friend' => 'friend',
    'relationship_type_friend_female' => 'friend',
    'relationship_type_friend_with_name' => ':name’s friend',
    'relationship_type_friend_female_with_name' => ':name’s friend',

    'relationship_type_bestfriend' => 'best friend',
    'relationship_type_bestfriend_female' => 'best friend',
    'relationship_type_bestfriend_with_name' => ':name’s best friend',
    'relationship_type_bestfriend_female_with_name' => ':name’s best friend',

    'relationship_type_colleague' => 'colleague',
    'relationship_type_colleague_female' => 'colleague',
    'relationship_type_colleague_with_name' => ':name’s colleague',
    'relationship_type_colleague_female_with_name' => ':name’s colleague',

    'relationship_type_boss' => 'boss',
    'relationship_type_boss_female' => 'boss',
    'relationship_type_boss_with_name' => ':name’s boss',
    'relationship_type_boss_female_with_name' => ':name’s boss',

    'relationship_type_subordinate' => 'subordinate',
    'relationship_type_subordinate_female' => 'subordinate',
    'relationship_type_subordinate_with_name' => ':name’s subordinate',
    'relationship_type_subordinate_female_with_name' => ':name’s subordinate',

    'relationship_type_mentor' => 'mentor',
    'relationship_type_mentor_female' => 'mentor',
    'relationship_type_mentor_with_name' => ':name’s mentor',
    'relationship_type_mentor_female_with_name' => ':name’s mentor',

    'relationship_type_protege' => 'protege',
    'relationship_type_protege_female' => 'protege',
    'relationship_type_protege_with_name' => ':name’s protege',
    'relationship_type_protege_female_with_name' => ':name’s protege',

    'relationship_type_ex_husband' => 'ex husband',
    'relationship_type_ex_husband_female' => 'ex wife',
    'relationship_type_ex_husband_with_name' => 'exmarido de :name',
    'relationship_type_ex_husband_female_with_name' => 'exmujer de :name',
];
