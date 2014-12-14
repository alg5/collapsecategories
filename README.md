CollapseCategories
==================
What CollapseCategories (full version) can do:
- expands/collapses categories on the index page
- stores the state of the categories (for registered users only)
 - for each hidden category with unread post(s) adds an icon <img src='https://github.com/alg5/CollapseCategories/blob/master/styles/prosilver/theme/images/icon_mini_unread_forums.gif' /> in the caption
- works correctly with any other blocks on the index page( recent topics, simiar topics etc.)
- cannot be turned when CollapseCategoriesLight (light version that saves the states into localstorage) is turned on

Languages: English, Russian, Ukrainian

todo list
- stores the state of the categories in LocalStorage for guests
- switch in ACP to store category state in DB or LocalStorage
- responsive design 


Что умеет CollapseCategories( полная версия)
- разворачивает/сворачивает категории на главной странице списка форумов
- запоминает состояние категории в БД ( только для зарегистрированных пользователей)
- для скрытых категорий, в которых имеются непрочитаные сообщения, добавляет в заголовок иконку <img src='https://github.com/alg5/CollapseCategories/blob/master/styles/prosilver/theme/images/icon_mini_unread_forums.gif' />
- корректно работает с любыми добавленными на главную страницу блоками( recent topics, simiar topics и т.п)
- не включается в случае, если включено расширение CollapseCategoriesLight(облегчённая версия с сохр. состояния в localstorage) и не включается, если альтернативное расширение установлено

Поддерживаемые языки: английский, русский,  украинский

[![Build Status](https://travis-ci.org/alg5/CollapseCategories.svg?branch=master)](https://travis-ci.org/alg5/CollapseCategories)
