export default {
    route: {
        dashboard: 'Панель управління',
        introduction: 'Введення',
        documentation: 'Документація',
        guide: 'Інструкція',
        permission: 'Права',
        pagePermission: 'Сторінка прав',
        rolePermission: 'Права ролей',
        directivePermission: 'Права для шляхів',
        icons: 'Іконки',
        components: 'Компоненти',
        componentIndex: 'Введення',
        tinymce: 'Tinymce',
        markdown: 'Markdown',
        jsonEditor: 'JSON Editor',
        dndList: 'Dnd List',
        splitPane: 'SplitPane',
        avatarUpload: 'Завантаження аватару',
        dropzone: 'Dropzone',
        sticky: 'Sticky',
        countTo: 'CountTo',
        componentMixin: 'Mixin',
        backToTop: 'Кнопка "Вгору"',
        dragDialog: 'Drag Dialog',
        dragSelect: 'Drag Select',
        dragKanban: 'Drag Kanban',
        charts: 'Графіки',
        keyboardChart: 'Стовпчастий графік',
        lineChart: 'Лінійний графік',
        mixChart: 'Змішаний графік',
        example: 'Приклад',
        nested: 'Вкладене меню',
        menu1: 'Меню 1',
        'menu1-1': 'Меню 1-1',
        'menu1-2': 'Меню 1-2',
        'menu1-2-1': 'Меню 1-2-1',
        'menu1-2-2': 'Меню 1-2-2',
        'menu1-3': 'Меню 1-3',
        menu2: 'Меню 2',
        table: 'Таблиця',
        dynamicTable: 'Динамічна',
        dragTable: 'С переносом рядків',
        inlineEditTable: 'С редагуванням',
        complexTable: 'Комплексна',
        treeTable: 'Древовидная',
        customTreeTable: 'Кастомное древо',
        tab: 'Вкладки',
        form: 'Форма',
        createArticle: 'Создать статью',
        editArticle: 'Изменить статью',
        articleList: 'Статьи',
        errorPages: 'Страницы ошибок',
        page401: '401',
        page404: '404',
        errorLog: 'Лог ошибок',
        excel: 'Excel',
        exportExcel: 'Экспорт в Excel',
        selectExcel: 'Экспорт выбранных строк',
        mergeHeader: 'Склееные заголовки',
        uploadExcel: 'Импорт Excel файла',
        zip: 'Zip',
        pdf: 'PDF',
        exportZip: 'Экспорт в Zip',
        theme: 'Тема',
        clipboardDemo: 'Буфер обмена',
        i18n: 'I18n',
        externalLink: 'Внешняя ссылка',
        elementUi: 'Element UI',
        administrator: 'Администратор',
        users: 'Користувачі',
        orders: 'Замовлення',
        userProfile: 'Профиль пользователя',
        edit_order: 'Редагування Замовлення',
    },
    navbar: {
        logOut: 'Выход',
        dashboard: 'Панель управления',
        github: 'Github',
        theme: 'Тема',
        size: 'Размер интерфейса',
        profile: 'Профиль',
    },
    login: {
        title: 'Авторизация',
        logIn: 'Войти',
        username: 'Username',
        password: 'Пароль',
        any: 'любой',
        thirdparty: 'Или войдите с помощью',
        thirdpartyTips: 'Can not be simulated on local, so please combine you own business simulation! ! !',
        email: 'Email',
    },
    documentation: {
        documentation: 'Документация',
        laravel: 'Laravel',
        github: 'Репозиторий Github',
    },
    permission: {
        addRole: 'Новая роль',
        editPermission: 'Редактировать право',
        roles: 'Ваши роли',
        switchRoles: 'Сменить роль',
        tips: 'В некоторых случаях не рекомендуется использовать v-role/v-permission, например в Tab компонентах или в el-table-column, и в других  элементах, у которых dom структура рендерится асинхронно. Вместо этого используйте v-if с checkRole и/или checkPermission.',
        delete: 'Удалить',
        confirm: 'Подтвердить',
        cancel: 'Отменить',
    },
    guide: {
        description: 'Инструкция полезна для тех, кто использует этот проект впервые. Вы можете кратко ознакомится с ним. Демо основано на',
        button: 'Показать инструкцию',
    },
    components: {
        documentation: 'Документация',
        tinymceTips: 'Rich text редактор является основной частью систем управления, но также у него имеется множество проблем. Выбирая rich text редактор, я испробовал разные. В основном все используют обычные rich text редакторы, но в итоге выбирают Tinymce. Смотрите документацию для подробных сравнений и ознакомления.',
        dropzoneTips: 'Поскольку у моего бизнеса есть нужды в особом функционале, и он должен загружать изображения в qiniu, вместо сторонних библиотек я инкапсулировал dropzone сам.  Это очень просто, вы можете увидеть подробный код в @/components/Dropzone.',
        stickyTips: 'Когда страница спускается до заданной позиции, элемент приклеивается к верху.',
        backToTopTips1: 'Когда страница спускается до заданной позиции, кнопка "подняться вверх" появляется в ннижнем правом углу.',
        backToTopTips2: 'Вы можете изменить стили кнопки, анимацию появления/исчезания, высоту на которой она появится/исчезнет. Если Вам нужно отобразить текст, вы можете использовать element-ui el-tooltip внешне, как в примере.',
        imageUploadTips: 'Ввиду того, что я использовал версию vue@1, и в данный момент она не совместима с mockjs, я модифицировал её сам. И если вы собираетесь её использовать, лучше использовать официальную версию.',
    },
    table: {
        description: 'Опис',
        dynamicTips1: 'Фиксированная ширина столбцов, фиксированный порядок столбцов',
        dynamicTips2: 'Изменяемая ширина столбцов, сортировка порядка столбцов по клику',
        dragTips1: 'Изначальный порядок элементов',
        dragTips2: 'Порядок после перетаскивания элементов',
        name: 'Ім\'я',
        title: 'Заголовок',
        importance: 'Важливість',
        type: 'Тип',
        remark: 'Замітка',
        search: 'Пошук',
        add: 'Додати',
        export: 'Експортувати',
        reviewer: 'Перевіряючий',
        id: '№',
        date: 'Дата',
        author: 'Автор',
        readings: 'Переглянуто',
        status: 'Статус',
        actions: 'Дії',
        edit: 'Змінити',
        publish: 'Опублікувати',
        draft: 'Чорновик',
        delete: 'Видалити',
        cancel: 'Відмінити',
        confirm: 'Підтвердити',
        keyword: 'Ключове слово',
        role: 'Роль',
        email: 'Пошта',
        deleted: 'Видалено',
        delete_cancelled: 'Видалення скасовано',
        user_deleting_msg: 'Це назавжди видалить користувача {username}. Продовжити?',
        warning: 'Увага',
        create_new_order: 'Створити нове замовлення',
        phone: 'Телефон',
        master: 'Майстер',
        city: 'Місто',
        total_cost: 'Сума замовлення',
        created_at: 'Дата створення',
        master_is_searching: 'В пошуку',
        total_cost_not_set: '-',
        status_new: 'Нове замовлення',
        status_is_pending: 'Пошук майстра',
        status_in_progress: 'Виконується майстром',
        status_done_by_master: 'Завершено майстром',
        status_checking_by_manager: 'Перевіряється менеджером',
        status_completed: 'Завершено',
        status_cancelled: 'Скасовано',
        order_created: 'Замовлення успішно створено',
    },
    errorLog: {
        tips: 'Пожалуйста, нажмите на иконку "бага" в правом верхнем углу',
        description: 'Сейчас система управления это SPA (single page application). Это улучшает удобство интерфейса, но так же увеличивает вероятность появления ошибок, которые могут привести к тупиковой странице (т.е. придеться перезагрузить страницу). К счастью Vue предоставляет перехват исключений, где вы можете обработать ошибку или сообщить об исключении.',
        documentation: 'Введение в документацию',
    },
    excel: {
        export: 'Экспорт',
        selectedExport: 'Экспортировать выбранные строки',
        placeholder: 'Пожалуйста, введите название файла (по умолчанию excel-list)',
    },
    zip: {
        export: 'Экспорт',
        placeholder: 'Пожалуйста, введите название файла (по умолчанию file)',
    },
    pdf: {
        tips: 'Здесь мы используем window.print(), для реализации скачивания pdf файла.',
    },
    theme: {
        change: 'Изменить тему',
        documentation: 'Документация по темам',
        tips: 'Подсказка: Это отличается от смены темы на панели навигации, это два разных метода смены темы, с разными реализациями кода. Больше информации, в документации.',
    },
    tagsView: {
        refresh: 'Обновить',
        close: 'Закрыть',
        closeOthers: 'Закрыть остальные',
        closeAll: 'Закрыть все',
    },
    settings: {
        title: 'Настройка стилей страниц',
        theme: 'Цвет темы',
        tagsView: 'Отображать вкладки',
        fixedHeader: 'Зафиксировать панель навигации',
        sidebarLogo: 'Логотип на боковой панели',
    },
    user: {
        'role': 'Роль',
        'password': 'Пароль',
        'confirmPassword': 'Підтвердити пароль',
        'name': 'Ім\'я',
        'email': 'Пошта',
        'create_title': 'Створити нового користувача',
        tabs: {
            account: 'Профіль',
            edit: 'Редагування',
            timeline: 'Часова шкала',
        },
    },
    roles: {
        description: {
            admin: 'Super Administrator. Есть доступ и права для всех страниц',
            manager: 'Manager. Есть доступ и права к большинству страниц, кроме страницы прав.',
            editor: 'Editor. Имеет доступ к большинству страниц, все права для статей и связанных ресурсов.',
            user: 'Normal user. Есть доступ к некоторым страницам.',
            visitor: 'Visitor. Имеют доступ к статическим страницам, не должны иметь прав на запись.',
        },
    },
    form: {
        first_name: 'Ім\'я',
        last_name: 'Прізвище',
        email: 'Пошта',
        date_of_birth: 'Дата Народження',
        pick_date: 'Виберіть Дату',
        about: 'Опис',
        skills: 'Навички',
        select_skills: 'Виберіть Навички',
        change_avatar: 'Змінити Аватар',
        update: 'Оновити',
        save: 'Зберегти',
        phone_number: 'Номер телефону',
        phone_number_placeholder: '0684637794',
        services: 'Послуги',
        select_services: 'Виберіть Послуги',
        city: 'Місто',
        select_city: 'Виберіть',
        address: 'Адреса',
        address_placeholder: 'вул. Незалежності 50, кв. 7, 2п',
        comment: 'Коментар',
        master: 'Майстер',
        select_master: 'Виберіть Майстра',
        tabs: {
            edit: 'Редагування',
            timeline: 'Часова шкала',
        },
        cancel_order: 'Скасувати',
        status: 'Статус',
        close: 'Закрити',
        confirm: 'Підтвердити',
        type_reason: 'Вкажіть причину',
    },
    order: {
        tabs: {
            edit: 'Редагування',
            timeline: 'Часова шкала',
        },
        saved: 'Замовлення успішно збережено'
    },
    notifications: {
        changed_language: 'Мову успішно змінено'
    }

};
