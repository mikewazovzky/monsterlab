<h1>
Полиморфизм при отображении набора компонент Vue
</h1>
<h3>Использование динамических компонент для отображения однотипных сущностей</h3>
<p>
Задача отображения или обработки набора однотипных сущностей, например имеющих
общий родительский класс или реализующих единый интерфейс, является типовой.
Примером такой задачи является реализованная на сайте система сообщений (notification)
информирующих пользователя о значимых для него событиях, например
оповещение автора статьи (post) о добавлении нового комментария к ней, или
администратора сайта о регистрации нового пользователя или публикации новой статьи.
</p>
<p>
Несмотря на очевидное наличие общих черт всех сообщений, налицо и очевидное различие между
разными их типами. Они содержат разный набор данных, например информацию о посте
или о пользователе, и, соответственно, должны отображаться по разному.
Каждому типу сообщения соответствует свой шаблон.
</p>
<p>
Решить задачу обработки (отображения в нашем случае) массива сообщений в общем цикле помогает
использование механизма динамических компонент
<a href="https://vuejs.org/v2/guide/components.html#Dynamic-Components">(Dynamic Components)</a>,
позволяющего производить выбор необходимого типа компоненты в момент построения (mounting) страницы.
Выбор компоненты производится с помощью ключевого слова <code>component</code> и привязки ее к нужной
компоненте с помощью ключевого слова <code>is</code> таким образом (пример из документации):
</p>
<pre><code>
<component v-bind:is="currentView">
    <!-- component changes when vm.currentView changes! -->
<component>
</code></pre>
<p>
Пример из жизни.
Компонента notification - обертка (wrapper) для использования в вышестоящей компоненте, как элемент массива.
</p>
<pre><code>
<!-- File Notification.vue -->

<template>
    <div>
        <component v-bind:is="type" :notification="notification"></component>
        <button class="btn btn-xs btn-info" @click="dismiss">Dismiss</button>
    </div>
</template>

<script>
    import UserRegistered from './UserRegistered.vue';
    import PostCreated from './PostCreated.vue';
    import Default from './Default.vue';

    export default {
        props: ['notification'],
        components: { UserRegistered, PostCreated },
        computed: {
            type() {
                return Object.keys(this.$options.components)
                    .includes(this.notification.type) ?
                    this.notification.type : 'Default';
            }
        },
        methods: {
            dismiss() {
                axios.delete(`/endpoint/${this.notification.id}`)
                    .then(() => this.$emit('dismissed'))
                    .catch(errors => console.log(errors));
            }
        }
    };
</script>

<!-- File UserRegistered.vue -->
<template>
    <div>
        New user
        <a :href="notification.user.link" v-text="notification.user.name"></a>
        has been REGISTERED.
    </div>
</template>

<script>
    export default {
        props: ['notification']
    };
</script>
</code></pre>
