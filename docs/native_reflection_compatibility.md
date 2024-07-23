## Typhoon Reflection adapters compatibility with native PHP reflection

| `ReflectionClass`                 | `Typhoon\Reflection\ClassReflection` |
|-----------------------------------|--------------------------------------|
| `IS_READONLY`                     | ✅ Defined for PHP 8.1                |
| `$name`                           | ✅                                    |
| `__construct()`                   | ❌ `@internal`                        |
| `__toString()`                    | ⚠️ Via native reflection             |
| `getAttributes()`                 | ✅                                    |
| `getConstant()`                   | ✅                                    |
| `getConstants()`                  | ✅                                    |
| `getConstructor()`                | ✅                                    |
| `getDefaultProperties()`          | ✅                                    |
| `getDocComment()`                 | ✅️                                   |
| `getEndLine()`                    | ✅                                    |
| `getExtension()`                  | ⚠️ Via native reflection             |
| `getExtensionName()`              | ✅                                    |
| `getFileName()`                   | ✅                                    |
| `getInterfaceNames()`             | ✅                                    |
| `getInterfaces()`                 | ✅                                    |
| `getMethods()`                    | ✅                                    |
| `getMethod()`                     | ✅                                    |
| `getModifiers()`                  | ✅                                    |
| `getName()`                       | ✅                                    |
| `getNamespaceName()`              | ✅                                    |
| `getParentClass()`                | ✅                                    |
| `getProperties()`                 | ✅                                    |
| `getProperty()`                   | ✅                                    |
| `getReflectionConstant()`         | ✅                                    |
| `getReflectionConstants()`        | ✅                                    |
| `getShortName()`                  | ✅                                    |
| `getStartLine()`                  | ✅️                                   |
| `getStaticProperties()`           | ⚠️ Via native reflection             |
| `getStaticPropertyValue()`        | ⚠️ Via native reflection             |
| `getTraitAliases()`               | ✅                                    |
| `getTraitNames()`                 | ✅                                    |
| `getTraits()`                     | ✅                                    |
| `hasConstant()`                   | ✅                                    |
| `hasMethod()`                     | ✅                                    |
| `hasProperty()`                   | ✅                                    |
| `implementsInterface()`           | ✅                                    |
| `inNamespace()`                   | ✅                                    |
| `isAbstract()`                    | ✅                                    |
| `isAnonymous()`                   | ✅                                    |
| `isCloneable()`                   | ✅                                    |
| `isEnum()`                        | ✅                                    |
| `isFinal()`                       | ✅                                    |
| `isInstance()`                    | ✅                                    |
| `isInstantiable()`                | ✅                                    |
| `isInterface()`                   | ✅                                    |
| `isInternal()`                    | ✅                                    |
| `isIterable()`                    | ✅                                    |
| `isIterateable()`                 | ✅                                    |
| `isReadOnly()`                    | ✅                                    |
| `isSubclassOf()`                  | ✅                                    |
| `isTrait()`                       | ✅                                    |
| `isUserDefined()`                 | ✅                                    |
| `newInstance()`                   | ⚠️ Via native reflection             |
| `newInstanceArgs()`               | ⚠️ Via native reflection             |
| `newInstanceWithoutConstructor()` | ⚠️ Via native reflection             |
| `setStaticPropertyValue()`        | ⚠️ Via native reflection             | 

| `ReflectionClassConstant` | `Typhoon\Reflection\ClassConstantReflection` |
|---------------------------|----------------------------------------------|
| `$class`                  | ✅                                            |
| `$name`                   | ✅                                            |
| `__construct()`           | ❌ `@internal`                                |
| `__toString()`            | ⚠️ Via native reflection                     |
| `getAttributes()`         | ✅                                            |
| `getDeclaringClass()`     | ✅                                            |
| `getDocComment()`         | ✅                                            |
| `getModifiers()`          | ✅                                            |
| `getName()`               | ✅                                            |
| `getType()`               | ✅                                            |
| `getValue()`              | ✅                                            |
| `hasType()`               | ✅                                            |
| `isEnumCase()`            | ✅                                            |
| `isFinal()`               | ✅                                            |
| `isPrivate()`             | ✅                                            |
| `isProtected()`           | ✅                                            |
| `isPublic()`              | ✅                                            |

| `ReflectionProperty`  | `Typhoon\Reflection\PropertyReflection` |
|-----------------------|-----------------------------------------|
| `$class`              | ✅                                       |
| `$name`               | ✅                                       |
| `__construct()`       | ❌ `@internal`                           |
| `__toString()`        | ⚠️ Via native reflection                |
| `getAttributes()`     | ✅                                       |
| `getDeclaringClass()` | ✅                                       |
| `getDefaultValue()`   | ✅                                       |
| `getDocComment()`     | ✅️                                      |
| `getModifiers()`      | ✅                                       |
| `getName()`           | ✅                                       |
| `getType()`           | ✅                                       |
| `getValue()`          | ⚠️ Via native reflection                |
| `hasDefaultValue()`   | ✅                                       |
| `hasType()`           | ✅                                       |
| `isDefault()`         | ✅                                       |
| `isInitialized()`     | ⚠️ Via native reflection                |
| `isPrivate()`         | ✅                                       |
| `isPromoted()`        | ✅                                       |
| `isProtected()`       | ✅                                       |
| `isPublic()`          | ✅                                       |
| `isReadOnly()`        | ✅                                       |
| `isStatic()`          | ✅                                       |
| `setAccessible()`     | ✅                                       |
| `setValue()`          | ⚠️ Via native reflection                |

| `ReflectionMethod`                | `Typhoon\Reflection\MethodReflection` |
|-----------------------------------|---------------------------------------|
| `$class`                          | ✅                                     |
| `$name`                           | ✅                                     |
| `__construct()`                   | ❌ `@internal`                         |
| `__toString()`                    | ⚠️ Via native reflection              |
| `createFromMethodName()`          | ❌ `@internal`                         |
| `getAttributes()`                 | ✅                                     |
| `getClosure()`                    | ⚠️ Via native reflection              |
| `getClosureCalledClass()`         | ✅                                     |
| `getClosureScopeClass()`          | ✅                                     |
| `getClosureThis()`                | ✅                                     |
| `getClosureUsedVariables()`       | ✅                                     |
| `getDeclaringClass()`             | ✅                                     |
| `getDocComment()`                 | ✅️                                    |
| `getEndLine()`                    | ✅                                     |
| `getExtension()`                  | ⚠️ Via native reflection              |
| `getExtensionName()`              | ✅                                     |
| `getFileName()`                   | ✅️                                    |
| `getModifiers()`                  | ✅                                     |
| `getName()`                       | ✅                                     |
| `getNamespaceName()`              | ✅                                     |
| `getNumberOfParameters()`         | ✅                                     |
| `getNumberOfRequiredParameters()` | ✅                                     |
| `getParameters()`                 | ✅                                     |
| `getPrototype()`                  | ✅                                     |
| `getReturnType()`                 | ✅                                     |
| `getShortName()`                  | ✅                                     |
| `getStartLine()`                  | ✅️                                    |
| `getStaticVariables()`            | ✅⚠️ Via native reflection             |
| `getTentativeReturnType()`        | ✅                                     |
| `hasPrototype()`                  | ✅                                     |
| `hasReturnType()`                 | ✅                                     |
| `hasTentativeReturnType()`        | ✅                                     |
| `inNamespace()`                   | ✅                                     |
| `invoke()`                        | ⚠️ Via native reflection              |
| `invokeArgs()`                    | ⚠️ Via native reflection              |
| `isAbstract()`                    | ✅                                     |
| `isClosure()`                     | ✅                                     |
| `isConstructor()`                 | ✅                                     |
| `isDeprecated()`                  | ✅                                     |
| `isDestructor()`                  | ✅                                     |
| `isFinal()`                       | ✅                                     |
| `isGenerator()`                   | ✅                                     |
| `isInternal()`                    | ✅                                     |
| `isPrivate()`                     | ✅                                     |
| `isProtected()`                   | ✅                                     |
| `isPublic()`                      | ✅                                     |
| `isStatic()`                      | ✅                                     |
| `isUserDefined()`                 | ✅                                     |
| `isVariadic()`                    | ✅                                     |
| `returnsReference()`              | ✅                                     |
| `setAccessible()`                 | ✅                                     |

| `ReflectionParameter`           | `Typhoon\Reflection\ParameterReflection` |
|---------------------------------|------------------------------------------|
| `$name`                         | ✅                                        |
| `__construct()`                 | ❌ `@internal`                            |
| `__toString()`                  | ⚠️ Via native reflection                 |
| `allowsNull()`                  | ✅                                        |
| `canBePassedByValue()`          | ✅                                        |
| `getAttributes()`               | ✅                                        |
| `getClass()`                    | ✅                                        |
| `getDeclaringClass()`           | ✅                                        |
| `getDeclaringFunction()`        | ✅                                        |
| `getDefaultValue()`             | ✅                                        |
| `getDefaultValueConstantName()` | ✅                                        |
| `getName()`                     | ✅                                        |
| `getPosition()`                 | ✅                                        |
| `getType()`                     | ✅                                        |
| `hasType()`                     | ✅                                        |
| `isArray()`                     | ✅                                        |
| `isCallable()`                  | ✅                                        |
| `isDefaultValueAvailable()`     | ✅                                        |
| `isDefaultValueConstant()`      | ✅                                        |
| `isOptional()`                  | ✅                                        |
| `isPassedByReference()`         | ✅                                        |
| `isPromoted()`                  | ✅                                        |
| `isVariadic()`                  | ✅                                        |

| `ReflectionAttribute` | `Typhoon\Reflection\AttributeReflection` |
|-----------------------|------------------------------------------|
| `__toString()`        | ⚠️ Via native reflection                 |
| `getArguments()`      | ✅                                        |
| `getName()`           | ✅                                        |
| `getTarget()`         | ✅                                        |
| `isRepeated()`        | ✅                                        |
| `newInstance()`       | ✅                                        |