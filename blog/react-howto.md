# React Component Philosophy:

React is a javacript library that allows people to "Build encapsulated components [...] then compose them to make complex UIs." There are a few associated concerns that need to be handled in doing this (stateful data mostly) but by and large the bulk of your react components should be structural UI's.

The syntax, JSX, is inspired heavily by HTML. Theoretically it could be used to describe any interface in any language. See React Native and ReactVR as examples of composable components being extended not just to other UI frameworks, but also very different platforms. This should inspire component authors break away from thinking "how do I find and manipulate these html nodes" and to think in terms of two things a) what data do I want to show, and b) how do I want to show it? There's no need to wire up all the transitions from $data1 to $data2, it's only a question of given _this_ data, what will the result be?

We use React components to realize this way of working. There are three types, each with slightly different api's and powers available to them. This means for some problems we might have a choise between a few components. Lets examine each component to see what we have to work with. Then we can look at the best approach to some common problems.

This is a Philosophy, not a rulebook. The solutions and code smells outlined here are, much like a coloring book, guidelines to stay within. Some ideas can be linted or tested for, and others only discovered by humans.


# Component types:

`extends React.Component`

Let's start with ES6 Class syntax. The recommended way to use React is with ES6 and JSX transpilation, so Class syntax is really the batteries-included way to define new components. In all cases you'll have some method that's returning more react components, in this case the render() method. With Class syntax you also get all the lifecycle like `componentDidMount`, `setState`, refs, and context.

`React.createClass({...})`

The createClass method was provided before ES6 class syntax was fully defined and available, as such it has all the same features as class syntax, plus one extra: it supports behavior mixins. Mixins are deprecated though, as they can be replaced with other patterns.

Stateless Functional Components

This style is simplified from class syntax, You only need to write a single, standalone, render() method and forego all the lifecycle, stateful methods, and refs that class syntax provides. In addition to being very fast to construct and easy to maintain, the react team has detailed plans to making these components render in a fraction of the time they do now. By removing api surface the library can get smarter.

If you find yourself making large `render()` methods, or `renderX()` and `renderY()` methods inside some other component, make a new Stateless Functional Component instead. Naming is hard, and making new files is hard, but in this situation it's worth it to split things up.



# The Philosophy

## Stateless Functional Component

https://facebook.github.io/react/docs/components-and-props.html

If a component does not own it's state you should define a Stateless Functional Component. These components are purely presentational. They will only a) render what they're given, and b) assert that they are given everything they expect.

Stateless Functional Components might not be the bulk of your app, but the more you have then the easier it will be to contain state elsewhere. State is what creates complexity and bugs. It turns out that simple render methods are easy to test and and maintain (see snapshot testing). So give them descriptive names, split them into tiny files, and trim and edit to keep as much nasty logic as possible outside of these components, your coverage and release confidance will improve greatly.

Note: It's ok to pass callbacks into these components. Props like `onClick` for a button, or `onPickItem` with `onCancel` for a list make a lot of sense. These callback props should be passed in so that the parent component can handle the action and update state. Intercepting events and turning event objects into domain data is very acceptable, `onPickItem()` should really be passed an Item object, and be protected from knowing about clicks/taps/keypresses.


## Container Component

http://redux.js.org/docs/basics/UsageWithReact.html

To make Stateless Functional Components work they need state. That state comes from a Container Component. This is where you want to centralize, whether it be calls to `setState()` or access to external state in a redux store.

For simple apps with setState calls, containers will be the components that define those onClick and onItemPicked callback methods. When you notice these calls getting threaded down into many children consider splitting your state into different Containers, some closer down the tree, or if it's time to use an external state helper.

Typically if you have external state (redux, or simply api calls) then the Container will also make use of lifecycle hooks to register event listeners.

Testing is possible by mocking the children and inspecting the props that are passed in. You can invoking the callback-props that are passed down or by triggering events that the component is subscribed to and validating that the lifecycle hooks interact correctly.


## Define props.children as Function

As a by-product of Stateless functional components, react allows functions to be defined directly inside JSX tags and passed as the child element. This gives us a lightweight way to create adapters inside the render() method that glue Containers and Presentational components with different prop-types together.

Functions defined inline like this are not accessable directly by tests. But by mocking the return value of the function you can assert that is passes the expected params.


## Higher-Order Component

HoC's are not a hammer, they're more like a stiff 6-inch boning/filet knife: good for preparing beef and pork, not preferred for chicken or fish.

As the documentation lays out, HoCs are a means to wrap a component and all it's lifecycle events. It's a great way to add cross cutting behavior. Overusing HoC's on the other hand to pass props can make your api's very rigid by forcing shared prop names across the codebase. See "Define props.children as Function" as an alternative.

Be aware that HoCs add extra behavior __when your module is defined__. This can complicate testing & mocks of the wrapped component as you may have to do more work to mock the cross-cutting dependencies as well as the component under test.


## Lifecycle Hooks - didMount

Lifecycle hooks are almost always defined in pairs, mount/unmount, etc. Typically the didMount hook will fetch some data, or subscribe to an event. Each of these could have a corresponding teardown event, such as fetch.abort (short-circuit the handler) or unsubscribe. Failing to cleanup in this way is a popular way to create real memory leaks.

You may find it tedious or error prone to prevent memory leaks in every component, HoC's are a way to solve for this, use them sparingly.


## Child components

TODO
Perf drain. Have many, small trees. Containers are your friend here.


## Context

Warning: Context creates tight coupling that is not statically knowable. Errors can only be detected at runtime. This coupling, unlike almost everything else about react, creates components that are very difficult to change. It is best to isolate and abstract over any uses of Context, to minimize the coupling.

Using Context means creating two components: a ContextProvider and a ContextConsumer. Ideally there will be no more than one Consumer for a given field in a Provider.

If a Provider has not created the required fields for a Consumer then that consumer will throw a runtime error when it is mounted.

Context does allow for data to be passed transparently from the Provder node down to any Consumers, without intermediate components knowing. This is best applied to cases like i18n laguage maps, the http request or user objects, and static objects of that nature.
For example, an i18n object with a translate method can be wrapped in an `<i18n>` component so that zero Presentational components need to read from context, but all may output translated text.
Or an HTTP request maybe be set in the context, and then an HTTPRequest component can read and forward the into an inline function:
```
<HTTPRequest>
  {(request) =>
    <span>Browsing with {request['User-Agent']}</span>
}
</HTTPRequest>
```


## PureRender

Children are the devil, perf wise. If you have a tree with `TopContainer` -> `A` -> `B` then any state that changes in `TopContainer` will force both A and B to re-render. If possible consider creating an `A_Container` and `B_Container` that each access the specific slice of state that they need. This way if `A_Container` rerenders, then `B_Container` can decide for itself it if should.

## React.PureComponent

PureComponent implements shallow-compare inside shouldComponentUpdate method suitable for comparing scalar values and immutable data structures. If a class expects a prop to be passed by ref (such as `[]` or `{}`) then the shallow compare will not detect changes to the contends of the object and will not cause a re-render.



# Types

Use type checking. Start annotating your source as early as possible. Flowtype or TypeScript are valid options. They both provide safety incrementally at compile time.

If you have a large amount of non-typed code then consider __also__ using PropTypes. Proptypes provider safety at runtime only.

If you are starting out and have zero types, consider writing Flowtypes, and then using babel plugins to automatically generate proptypes. This reduces the review burden of typing things twice and provides maximum value.

The engineering overhead of adding types is multiple orders of magnitude less if they are applied as a component is being built, rather than 'later'. Types will make certain unit tests obsolete, guide the design of the system, and serve as living documentation. Typically the engineer knows the expected types while they're building the module (see hungarian notation), and can quickly annotate simple cases. Encountering complex type requirements might be a code smell, but it is an opportunity to either a) simplify, or b) document for the next person.


# Smells

## Smell: Component splats many props into children

A common smell is for a component to accept props for the sole purpose of passing them through, unmodified, to a child component. Typically this pattern grows banicles and gets worse over time, with a large number of props being passed deeply into the tree below, sometimes multiple layers deep, before being rendered.

The solution is to access state from a Container node that is closer to the Presentational component that requires it. This way many Container Components may be reading the same state throughout the tree, and ancestor components will be more agnostic towards the specific child components and their props. This also creates performance improvements as fewer nodes will need to re-render when the data changes.


## Smell: Many Callbacks passed into children

If you have a Component that accepts many callbacks as props, resist the temptation to create one generic callback that will update state in any manner. Consider first splitting the component into multiple parts, each of which accepts a smaller list of callbacks. Also, consider creating more Containers to produce callbacks at a lower level, rather than forwarding them down the tree.


## Smell: ForceUpdate

Don't do it.
If you are using ForceUpdate and reading about it here, you are doing something wrong. This is an escape hatch for when state isn't well defined or contained. ForceUpdate can enable non-react children to co-exist within your codebase, but that should be the exception, just like __dangerouslySetInnerHTML this is a smell to be avoided.


## Smell: __dangerouslySetInnerHTML

Don't do it.
If you are using __dangerouslySetInnerHTML and reading about it here, you are doing something wrong. This is an escape hatch for non-react or static content, and it requires data to be escaped manually. Injection was the #1 security vulerability in the OWASP Top Ten list for 2010 and 2013, which is preventable using properly escaped data.











































