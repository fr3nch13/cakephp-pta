# [CakePHP Jira Plugin API Documentation](../home.md)

# Class: \Fr3nch13\Pta\Plugin
### Namespace: [\Fr3nch13\Pta](../namespaces/Fr3nch13.Pta.md)
---
**Summary:**

CakePHP PTA Plugin

---
### Constants
* No constants found
---
### Properties
---
### Methods
* [public bootstrap()](../classes/Fr3nch13.Pta.Plugin.md#method_bootstrap)
* [public middleware()](../classes/Fr3nch13.Pta.Plugin.md#method_middleware)
* [public routes()](../classes/Fr3nch13.Pta.Plugin.md#method_routes)
* [protected bootstrapCli()](../classes/Fr3nch13.Pta.Plugin.md#method_bootstrapCli)
---
### Details
* File: [Plugin.php](../files/Plugin.md)
* Package: Default
* Class Hierarchy: 
  * [\Cake\Core\BasePlugin]()
  * \Fr3nch13\Pta\Plugin

---
## Methods
<a name="method_bootstrap" class="anchor"></a>
#### public bootstrap() : void

```
public bootstrap(\Cake\Core\PluginApplicationInterface  $app) : void
```

**Summary**

Bootstraping for this specific plugin.

**Details:**
* Inherited From: [\Fr3nch13\Pta\Plugin](../classes/Fr3nch13.Pta.Plugin.md)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>\Cake\Core\PluginApplicationInterface</code> | $app  | The app object. |

**Returns:** void


<a name="method_middleware" class="anchor"></a>
#### public middleware() : object

```
public middleware(object  $middleware) : object
```

**Summary**

Load needed Middleware

**Details:**
* Inherited From: [\Fr3nch13\Pta\Plugin](../classes/Fr3nch13.Pta.Plugin.md)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>object</code> | $middleware  | The passed middleware object. |

**Returns:** object - The modified middleware object.


<a name="method_routes" class="anchor"></a>
#### public routes() : void

```
public routes(object  $routes) : void
```

**Summary**

Add plugin specific routes here.

**Details:**
* Inherited From: [\Fr3nch13\Pta\Plugin](../classes/Fr3nch13.Pta.Plugin.md)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>object</code> | $routes  | The passed routes object. |

**Returns:** void


<a name="method_bootstrapCli" class="anchor"></a>
#### protected bootstrapCli() : void

```
protected bootstrapCli(\Cake\Core\PluginApplicationInterface  $app) : void
```

**Summary**

More bootstrapping if we're running on the command line.

**Details:**
* Inherited From: [\Fr3nch13\Pta\Plugin](../classes/Fr3nch13.Pta.Plugin.md)
##### Parameters:
| Type | Name | Description |
| ---- | ---- | ----------- |
| <code>\Cake\Core\PluginApplicationInterface</code> | $app  | The app object. |

**Returns:** void



---

### Top Namespaces

* [\Fr3nch13](../namespaces/Fr3nch13.html.md)

---

### Reports
* [Errors - 2](../reports/errors.md)
* [Markers - 0](../reports/markers.md)
* [Deprecated - 0](../reports/deprecated.md)

---

This document was automatically generated from source code comments on 2019-11-22 using [phpDocumentor](http://www.phpdoc.org/) and [fr3nch13/phpdoc-markdown](https://github.com/fr3nch13/phpdoc-markdown)
