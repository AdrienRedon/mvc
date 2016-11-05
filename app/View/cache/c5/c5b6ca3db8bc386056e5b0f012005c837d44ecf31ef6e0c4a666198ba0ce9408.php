<?php

/* layout/main.twig */
class __TwigTemplate_3914ec57b5a7a47bc49bde41d8295374fb44b5760a83e839766aab6dfc9cdf64 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
<head>
    <title>MVC</title>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["asset"]) ? $context["asset"] : null), "path", array(0 => "app.css"), "method"), "html", null, true);
        echo "\">
</head>
<body>
    ";
        // line 8
        $this->displayBlock('content', $context, $blocks);
        // line 9
        echo "    <script type=\"text/javascript\" src=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["asset"]) ? $context["asset"] : null), "path", array(0 => "app.js"), "method"), "html", null, true);
        echo "\"></script>
</body>
</html>";
    }

    // line 8
    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "layout/main.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  42 => 8,  34 => 9,  32 => 8,  26 => 5,  20 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html>
<head>
    <title>MVC</title>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"{{ asset.path('app.css') }}\">
</head>
<body>
    {% block content %}{% endblock %}
    <script type=\"text/javascript\" src=\"{{ asset.path('app.js') }}\"></script>
</body>
</html>", "layout/main.twig", "/Users/adrien/Sites/mvc/app/View/layout/main.twig");
    }
}
