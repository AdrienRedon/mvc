<?php

/* Page/index.twig */
class __TwigTemplate_d3974f37bce55cb780f460ff4a8c09fe6c44ed6e6f79c5b9c8a6f760aebb5fd6 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout/main.twig", "Page/index.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout/main.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "    <h1>Hello World</h1>
    <div id=\"app\"></div>
";
    }

    public function getTemplateName()
    {
        return "Page/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  31 => 4,  28 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends 'layout/main.twig' %}

{% block content %}
    <h1>Hello World</h1>
    <div id=\"app\"></div>
{% endblock %}", "Page/index.twig", "/Users/adrien/Sites/mvc/app/View/Page/index.twig");
    }
}
