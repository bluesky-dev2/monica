<?php

return [
    'update' => 'Bijwerken',
    'save' => 'Opslaan',
    'add' => 'Toevoegen',
    'cancel' => 'Annuleren',
    'delete' => 'Verwijderen',
    'edit' => 'Bewerken',
    'upload' => 'Uploaden',
    'close' => 'Sluiten',
    'create' => 'Maak',
    'remove' => 'Verwijderen',
    'revoke' => 'Intrekken',
    'done' => 'Gereed',
    'verify' => 'Bevestigen',
    'for' => 'voor',
    'new' => 'nieuw',
    'unknown' => 'Ik weet het niet',
    'load_more' => 'Meer laden',
    'loading' => 'Laden...',
    'with' => 'met',
    'days' => 'dag|dagen',

    'application_title' => 'Monica – persoonlijke relatie manager',
    'application_description' => 'Monica is een app voor het beheren van interacties met uw geliefden, vrienden en familie.',
    'application_og_title' => 'Bouw betere relaties met uw dierbaren. Gratis Online CRM voor vrienden en familie.',

    'markdown_description' => 'Wilt u uw tekst opmaken op een leuke manier? Wij ondersteunen Markdown om vet, cursief, lijsten en meer toe te voegen.',
    'markdown_link' => 'Lees documentatie',

    'header_settings_link' => 'Instellingen',
    'header_logout_link' => 'Uitloggen',
    'header_changelog_link' => 'Productwijzigingen',

    'main_nav_cta' => 'Personen toevoegen',
    'main_nav_dashboard' => 'Dashboard',
    'main_nav_family' => 'Contacten',
    'main_nav_journal' => 'Dagboek',
    'main_nav_activities' => 'Activiteiten',
    'main_nav_tasks' => 'Taken',

    'footer_remarks' => 'Eventuele opmerkingen?',
    'footer_send_email' => 'Stuur me een e-mail',
    'footer_privacy' => 'Privacy beleid',
    'footer_release' => 'Releaseopmerkingen',
    'footer_newsletter' => 'Nieuwsbrief',
    'footer_source_code' => 'Bijdragen',
    'footer_version' => 'Versie: :version',
    'footer_new_version' => 'Er is een nieuwe versie beschikbaar',

    'footer_modal_version_whats_new' => 'Wat is er nieuw',
    'footer_modal_version_release_away' => 'Je loopt 1 versie achter op de laatst beschikbare versie. Je zou je applicatie moeten bijwerken.|Je loopt :number versies achter op de laatst beschikbare versie. Je zou je applicatie moeten bijwerken.',

    'breadcrumb_dashboard' => 'Dashboard',
    'breadcrumb_list_contacts' => 'Lijst van mensen',
    'breadcrumb_journal' => 'Dagboek',
    'breadcrumb_settings' => 'Instellingen',
    'breadcrumb_settings_export' => 'Exporteren',
    'breadcrumb_settings_users' => 'Gebruikers',
    'breadcrumb_settings_users_add' => 'Gebruiker toevoegen',
    'breadcrumb_settings_subscriptions' => 'Abonnement',
    'breadcrumb_settings_import' => 'Importeren',
    'breadcrumb_settings_import_report' => 'Importrapport',
    'breadcrumb_settings_import_upload' => 'Uploaden',
    'breadcrumb_settings_tags' => 'Labels',
    'breadcrumb_add_significant_other' => 'Partner toevoegen',
    'breadcrumb_edit_significant_other' => 'Partner bewerken',
    'breadcrumb_add_note' => 'Notitie toevoegen',
    'breadcrumb_edit_note' => 'Notitie bewerken',
    'breadcrumb_api' => 'API',
    'breadcrumb_edit_introductions' => 'Hoe hebben jullie elkaar ontmoet',
    'breadcrumb_settings_personalization' => 'Personalisatie',
    'breadcrumb_settings_security' => 'Beveiliging',
    'breadcrumb_settings_security_2fa' => 'Tweestapsverificatie',
    'breadcrumb_profile' => 'Profiel van :name',

    'gender_male' => 'Man',
    'gender_female' => 'Vrouw',
    'gender_none' => 'Zeg ik liever niet',

    'error_title' => 'Oeps! Er is iets misgegaan.',
    'error_unauthorized' => 'Je hebt niet de rechten om dit onderdeel te bewerken.',
    'error_save' => 'Er is een fout opgetreden bij het opslaan van de gegevens.',

    'default_save_success' => 'De gegevens zijn opgeslagen.',

    'compliance_title' => 'Sorry voor de onderbreking.',
    'compliance_desc' => 'We hebben onze <a href=":urlterm" hreflang=":hreflang">gebruiksvoorwaarden </a> en <a href=":url" hreflang=":hreflang">privacybeleid</a> aangepast. We zijn verplicht u te vragen deze opnieuw te lezen en goed te keuren om uw account te kunnen blijven gebruiken.',
    'compliance_desc_end' => 'Wij doen niets vervelends met uw gegevens of account en zullen dit ook nooit doen.',
    'compliance_terms' => 'Accepteer de nieuwe voorwaarden en privacybeleid',

    // Relationship types
    // Yes, each relationship type has 8 strings associated with it.
    // This is because we need to indicate the name of the relationship type,
    // and also the name of the opposite side of this relationship (father/son),
    // and then, the feminine version of the string. Finally, in some sentences
    // in the UI, we need to include the name of the person we add the relationship
    // to.
    'relationship_type_group_love' => 'Liefdesrelaties',
    'relationship_type_group_family' => 'Familierelaties',
    'relationship_type_group_friend' => 'Vriendschappen',
    'relationship_type_group_work' => 'Collega\'s',
    'relationship_type_group_other' => 'Andere relaties',

    'relationship_type_partner' => 'partner',
    'relationship_type_partner_female' => 'partner',
    'relationship_type_partner_with_name' => ':name\'s van partner',
    'relationship_type_partner_female_with_name' => ':name’s van partner',

    'relationship_type_spouse' => 'echtgenoot',
    'relationship_type_spouse_female' => 'echtgenoot',
    'relationship_type_spouse_with_name' => ':name’s van echtgeno(o)t(e)',
    'relationship_type_spouse_female_with_name' => ':name’s van echtgeno(o)t(e)',

    'relationship_type_date' => 'date',
    'relationship_type_date_female' => 'date',
    'relationship_type_date_with_name' => ':name’s date',
    'relationship_type_date_female_with_name' => ':name\'s date',

    'relationship_type_lover' => 'geliefde',
    'relationship_type_lover_female' => 'geliefde',
    'relationship_type_lover_with_name' => ':name’s geliefde',
    'relationship_type_lover_female_with_name' => ':name’s geliefde',

    'relationship_type_inlovewith' => 'verliefd op',
    'relationship_type_inlovewith_female' => 'verliefd op',
    'relationship_type_inlovewith_with_name' => 'iemand :name is verliefd op',
    'relationship_type_inlovewith_female_with_name' => 'iemand :name is verliefd op',

    'relationship_type_lovedby' => 'begeert door',
    'relationship_type_lovedby_female' => 'begeert door',
    'relationship_type_lovedby_with_name' => ':name’s geheime minnaar',
    'relationship_type_lovedby_female_with_name' => ':name’s geheime minnaar',

    'relationship_type_ex' => 'ex-vriendje',
    'relationship_type_ex_female' => 'ex-vriendin',
    'relationship_type_ex_with_name' => ':name’s ex-vriendje',
    'relationship_type_ex_female_with_name' => ':name’s ex-vriendinnetje',

    'relationship_type_parent' => 'vader',
    'relationship_type_parent_female' => 'moeder',
    'relationship_type_parent_with_name' => ':name’s vader',
    'relationship_type_parent_female_with_name' => ':name’s moeder',

    'relationship_type_child' => 'zoon',
    'relationship_type_child_female' => 'dochter',
    'relationship_type_child_with_name' => ':name’s zoon',
    'relationship_type_child_female_with_name' => ':name’s dochter',

    'relationship_type_sibling' => 'broer',
    'relationship_type_sibling_female' => 'zus',
    'relationship_type_sibling_with_name' => ':name’s broer',
    'relationship_type_sibling_female_with_name' => ':name’s zus',

    'relationship_type_grandparent' => 'grootouder',
    'relationship_type_grandparent_female' => 'grootouder',
    'relationship_type_grandparent_with_name' => ':name’s grootouder',
    'relationship_type_grandparent_female_with_name' => ':name’s grootouder',

    'relationship_type_grandchild' => 'kleinkind',
    'relationship_type_grandchild_female' => 'kleinkind',
    'relationship_type_grandchild_with_name' => ':name’s kleinkind',
    'relationship_type_grandchild_female_with_name' => ':name’s kleinkind',

    'relationship_type_uncle' => 'oom',
    'relationship_type_uncle_female' => 'tante',
    'relationship_type_uncle_with_name' => ':name’s oom',
    'relationship_type_uncle_female_with_name' => ':name’s tante',

    'relationship_type_nephew' => 'neef',
    'relationship_type_nephew_female' => 'nicht',
    'relationship_type_nephew_with_name' => ':name’s neef',
    'relationship_type_nephew_female_with_name' => ':name’s nicht',

    'relationship_type_cousin' => 'neef',
    'relationship_type_cousin_female' => 'neef',
    'relationship_type_cousin_with_name' => ':name’s neef',
    'relationship_type_cousin_female_with_name' => ':name’s neef',

    'relationship_type_godfather' => 'peetoom',
    'relationship_type_godfather_female' => 'peet moeder',
    'relationship_type_godfather_with_name' => ':name\'s peetvader',
    'relationship_type_godfather_female_with_name' => ':name\'s peetmoeder',

    'relationship_type_godson' => 'peetzoon',
    'relationship_type_godson_female' => 'peetdochter',
    'relationship_type_godson_with_name' => ':name\'s schoonzoon',
    'relationship_type_godson_female_with_name' => ':name\'s schoondochter',

    'relationship_type_friend' => 'vriend',
    'relationship_type_friend_female' => 'vriend',
    'relationship_type_friend_with_name' => ':name’s vriend',
    'relationship_type_friend_female_with_name' => ':name’s vriend',

    'relationship_type_bestfriend' => 'beste Vriend',
    'relationship_type_bestfriend_female' => 'beste Vriend',
    'relationship_type_bestfriend_with_name' => ':name’s beste vriend',
    'relationship_type_bestfriend_female_with_name' => ':name’s beste vriend',

    'relationship_type_colleague' => 'collega',
    'relationship_type_colleague_female' => 'collega',
    'relationship_type_colleague_with_name' => ':name’s collega',
    'relationship_type_colleague_female_with_name' => ':name’s collega',

    'relationship_type_boss' => 'baas',
    'relationship_type_boss_female' => 'baas',
    'relationship_type_boss_with_name' => ':name’s baas',
    'relationship_type_boss_female_with_name' => ':name’s baas',

    'relationship_type_subordinate' => 'ondergeschikte',
    'relationship_type_subordinate_female' => 'ondergeschikte',
    'relationship_type_subordinate_with_name' => ':name’s ondergeschikte',
    'relationship_type_subordinate_female_with_name' => ':name’s ondergeschikte',

    'relationship_type_mentor' => 'mentor',
    'relationship_type_mentor_female' => 'mentor',
    'relationship_type_mentor_with_name' => ':name’s mentor',
    'relationship_type_mentor_female_with_name' => ':name’s mentor',

    'relationship_type_protege' => 'protege',
    'relationship_type_protege_female' => 'protege',
    'relationship_type_protege_with_name' => ':name’s protege',
    'relationship_type_protege_female_with_name' => ':name\'s protege',

    'relationship_type_ex_husband' => 'ex-echtgenoot',
    'relationship_type_ex_husband_female' => 'ex-vrouw',
    'relationship_type_ex_husband_with_name' => ':name’s ex echtgenoot',
    'relationship_type_ex_husband_female_with_name' => ':name’s ex-vrouw',
];
