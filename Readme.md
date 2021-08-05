# Flow + Fusion AFX example with root path

open http://127.0.0.1:8081/mhsdesign.flow.fusion/apple/new
i didnt set up routes, only enabled the flow routes ... e.g. {@package}/{@controller}(/{@action})

based on the fusion generator for flow [fusion template support](https://github.com/neos/flow-development-collection/pull/2365) ... thanks @albe


## a few things:

i found out, that you can set the FusionView and the fusionPath in these places:

(quick intro: the FusionView makes Flow use Fusion and the fusionPath makes Fusion render `root` instead of the path `My.Package.BananaController.show`, this way i can render prototypes dynamically. (see Fusion/DefaultFusion.fusion))

Views.yaml (the one im using - is global if no requestFilter)
```yaml
-
    viewObjectName: 'Neos\Fusion\View\FusionView'
    options:
        fusionPath: "root"

```

Settings.yaml (is global)
```yaml
Neos:
  Flow:
    mvc:
      view:
        defaultImplementation: Neos\Fusion\View\FusionView
        # no options see Neos.Flow/Resources/Private/Schema/Settings/Neos.Flow.mvc.schema.yaml
```

YourController.php (if you want to enable fusion per controller)
```php
class YourController extends ActionController
{
    protected $defaultViewObjectName = \Neos\Fusion\View\FusionView::class;

    protected function initializeView($view)
    {
        // you could also create a custom FusionView where this is already set:
        $view->setOption("fusionPath", "root");
    }
}

```


# the request context in fusion

```jsx
// MhsDesign\Flow\Fusion\Controller\AppleController
ControllerObjectName = ${request.controllerObjectName}
// MhsDesign.Flow.Fusion
ControllerPackageKey = ${request.controllerPackageKey}
// Apple
ControllerName = ${request.controllerName}
// new
ControllerActionName = ${request.controllerActionName}
```

## there is much more hidden in ${request}
request is an ActionRequest object: [Neos\Flow\Mvc\ActionRequest](https://github.com/neos/flow-development-collection/blob/master/Neos.Flow/Classes/Mvc/ActionRequest.php

## insight of the day: use php getter methods in eel
Neos\Flow\Mvc\ActionRequest has the method: getControllerObjectName

you can access getters (getWhatever) by using an array like syntax and leaving out the `get`:
`${request.controllerObjectName}`
the name seems to be case insensitive and the method cant take any parameters - i at least found no way to pass arguments while using this array syntax.

### this way you can also get the HttpRequest:
the method: `ActionRequest->getHttpRequest()`
eel in fusion: `${request.httpRequest}`

#### getting the http headers and more ServerParams via fusion:
httpRequest is a [Psr\Http\Message\ServerRequestInterface](https://github.com/php-fig/http-message/blob/master/src/ServerRequestInterface.php)

after looking at the ServerRequestInterface you can now for example access all http headers (and more stuff) via `getServerParams()`
eel in fusion: `${request.httpRequest.serverParams}`

btw `request.httpRequest.headers` works too for only the headers
