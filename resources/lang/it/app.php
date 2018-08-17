<?php

return [
    'update' => 'Aggiorna',
    'save' => 'Salva',
    'add' => 'Aggiungi',
    'cancel' => 'Cancella',
    'delete' => 'Rimuovi',
    'edit' => 'Modifica',
    'upload' => 'Carica',
    'close' => 'Chiudi',
    'create' => 'Crea',
    'remove' => 'Elimina',
    'revoke' => 'Revoca',
    'done' => 'Fatto',
    'verify' => 'Verifica',
    'for' => 'per',
    'new' => 'nuovo',
    'unknown' => 'Non so',
    'load_more' => 'Carica altro',
    'loading' => 'Caricamento in corso...',
    'with' => 'con',
    'days' => 'giorno | giorni',

    'application_title' => 'Monica – personal relationship manager',
    'application_description' => 'Monica è uno strumento per gestire le interazioni con i vostri cari, amici e familiari.',
    'application_og_title' => 'Avere migliori relazioni con i vostri cari. CRM Online gratuito per gli amici e la famiglia.',

    'markdown_description' => 'Vuoi formattare il tuo testo? Supportiamo Markdown per grassetto, corsivo, liste, e altro ancora.',
    'markdown_link' => 'Leggi documentazione',

    'header_settings_link' => 'Impostazioni',
    'header_logout_link' => 'Disconnettiti',
    'header_changelog_link' => 'Modifiche di prodotto',

    'main_nav_cta' => 'Aggiungi contatti',
    'main_nav_dashboard' => 'Home',
    'main_nav_family' => 'Contatti',
    'main_nav_journal' => 'Diario',
    'main_nav_activities' => 'Attività',
    'main_nav_tasks' => 'Compiti',

    'footer_remarks' => 'Commenti?',
    'footer_send_email' => 'Inviami una email',
    'footer_privacy' => 'Privacy',
    'footer_release' => 'Note di rilascio',
    'footer_newsletter' => 'Newsletter',
    'footer_source_code' => 'Monica su GitHub',
    'footer_version' => 'Versione: :version',
    'footer_new_version' => 'È disponibile una nuova versione',

    'footer_modal_version_whats_new' => 'Novità',
    'footer_modal_version_release_away' => 'La tua versione è 1 versione indietro rispetto all\'ultima disponibile. Dovresti aggiornare Monica.|La tua versione è :number versioni indietro rispetto all\'ultima disponibile. Dovresti aggiornare Monica.',

    'breadcrumb_dashboard' => 'Home',
    'breadcrumb_list_contacts' => 'Lista dei contatti',
    'breadcrumb_journal' => 'Diario',
    'breadcrumb_settings' => 'Impostazioni',
    'breadcrumb_settings_export' => 'Esporta',
    'breadcrumb_settings_users' => 'Utenti',
    'breadcrumb_settings_users_add' => 'Aggiungi un utente',
    'breadcrumb_settings_subscriptions' => 'Sottoscrizioni',
    'breadcrumb_settings_import' => 'Importa',
    'breadcrumb_settings_import_report' => 'Resoconto dell\'importazione',
    'breadcrumb_settings_import_upload' => 'Carica',
    'breadcrumb_settings_tags' => 'Etichette',
    'breadcrumb_add_significant_other' => 'Aggiungi partner',
    'breadcrumb_edit_significant_other' => 'Modifica partner',
    'breadcrumb_add_note' => 'Aggiungi una nota',
    'breadcrumb_edit_note' => 'Modifica nota',
    'breadcrumb_api' => 'API',
    'breadcrumb_edit_introductions' => 'Come vi siete conosciuti',
    'breadcrumb_settings_personalization' => 'Personalizzazione',
    'breadcrumb_settings_security' => 'Sicurezza',
    'breadcrumb_settings_security_2fa' => 'Autenticazione due fattori',
    'breadcrumb_profile' => 'Profile of :name',

    'gender_male' => 'Uomo',
    'gender_female' => 'Donna',
    'gender_none' => 'Preferisco non specificarlo',

    'error_title' => 'Ops! Qualcosa è andato storto.',
    'error_unauthorized' => 'Non hai il permesso di aggiornare questa risorsa.',
    'error_save' => 'Abbiamo avuto un errore cercando di salvare i dati.',

    'default_save_success' => 'I dati sono stati salvati.',

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
    'relationship_type_group_love' => 'Relazioni d\'amore',
    'relationship_type_group_family' => 'Relazioni familiari',
    'relationship_type_group_friend' => 'Rapporti di amicizia',
    'relationship_type_group_work' => 'Rapporti di lavoro',
    'relationship_type_group_other' => 'Altri tipi di relazioni',

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

    'relationship_type_lover' => 'amante',
    'relationship_type_lover_female' => 'amante',
    'relationship_type_lover_with_name' => ': nome amante',
    'relationship_type_lover_female_with_name' => ': nome amante',

    'relationship_type_inlovewith' => 'innamorati di',
    'relationship_type_inlovewith_female' => 'innamorati di',
    'relationship_type_inlovewith_with_name' => 'qualcuno: è innamorato di',
    'relationship_type_inlovewith_female_with_name' => 'someone :name is in love with',

    'relationship_type_lovedby' => 'loved by',
    'relationship_type_lovedby_female' => 'loved by',
    'relationship_type_lovedby_with_name' => ':name’s secret lover',
    'relationship_type_lovedby_female_with_name' => ':name’s secret lover',

    'relationship_type_ex' => 'ex-boyfriend',
    'relationship_type_ex_female' => 'ex-girlfriend',
    'relationship_type_ex_with_name' => ':name’s ex-boyfriend',
    'relationship_type_ex_female_with_name' => ':name’s ex-girlfriend',

    'relationship_type_parent' => 'father',
    'relationship_type_parent_female' => 'mother',
    'relationship_type_parent_with_name' => ':name’s father',
    'relationship_type_parent_female_with_name' => ':name’s mother',

    'relationship_type_child' => 'son',
    'relationship_type_child_female' => 'daughter',
    'relationship_type_child_with_name' => ':name’s son',
    'relationship_type_child_female_with_name' => ':name’s daughter',

    'relationship_type_sibling' => 'brother',
    'relationship_type_sibling_female' => 'sister',
    'relationship_type_sibling_with_name' => ':name’s brother',
    'relationship_type_sibling_female_with_name' => ':name’s sister',

    'relationship_type_grandparent' => 'grand parent',
    'relationship_type_grandparent_female' => 'grand parent',
    'relationship_type_grandparent_with_name' => ':name’s grand parent',
    'relationship_type_grandparent_female_with_name' => ':name’s grand parent',

    'relationship_type_grandchild' => 'grand child',
    'relationship_type_grandchild_female' => 'grand child',
    'relationship_type_grandchild_with_name' => ':name’s grand child',
    'relationship_type_grandchild_female_with_name' => ':name’s grand child',

    'relationship_type_uncle' => 'uncle',
    'relationship_type_uncle_female' => 'aunt',
    'relationship_type_uncle_with_name' => ':name’s uncle',
    'relationship_type_uncle_female_with_name' => ':name’s aunt',

    'relationship_type_nephew' => 'nephew',
    'relationship_type_nephew_female' => 'niece',
    'relationship_type_nephew_with_name' => ':name’s nephew',
    'relationship_type_nephew_female_with_name' => ':name’s niece',

    'relationship_type_cousin' => 'cousin',
    'relationship_type_cousin_female' => 'cugino',
    'relationship_type_cousin_with_name' => ': nome del cugino',
    'relationship_type_cousin_female_with_name' => ': nome del cugino',

    'relationship_type_godfather' => 'padrino',
    'relationship_type_godfather_female' => 'madrina',
    'relationship_type_godfather_with_name' => ': nome del padrino',
    'relationship_type_godfather_female_with_name' => ': nome della madrina',

    'relationship_type_godson' => 'godson',
    'relationship_type_godson_female' => 'goddaughter',
    'relationship_type_godson_with_name' => ':name’s godson',
    'relationship_type_godson_female_with_name' => ':name’s goddaughter',

    'relationship_type_friend' => 'amico',
    'relationship_type_friend_female' => 'amico',
    'relationship_type_friend_with_name' => ':name’s friend',
    'relationship_type_friend_female_with_name' => ':name’s friend',

    'relationship_type_bestfriend' => 'miglior amico',
    'relationship_type_bestfriend_female' => 'miglior amico',
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
    'relationship_type_ex_husband_with_name' => ':name’s ex husband',
    'relationship_type_ex_husband_female_with_name' => ':name’s ex wife',
];
